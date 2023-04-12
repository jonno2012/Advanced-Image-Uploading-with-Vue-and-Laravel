<template>
    <div>
        <div class="mt-4">
            <file-pond
                name="image"
                ref="pond"
                label-idle="Click to choose image or drag here..."
                @init="filepondInitialize"
                accepted-file-types="image/jpg, image/jpeg, image/png"
                @processFile="handleProcessedFile"
                allowMultiple="true"
                maxFileSize="1MB"
            />
        </div>
        <div class="mt-8 mb-24">
            <h3 class="text-2xl font-medium text-center">Image Gallery</h3>
            <div class="grid grid-cols-3 gap-2 justify-evenly mt-4">
                <div v-for="(image, index) in images" :key="index">
                    <img :src="'/storage/images/' + image">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vueFilepond, { setOptions } from "vue-filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginFileValidationType from 'filepond-plugin-file-validate-type';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';

let serverMessage = {};
setOptions({
    server: {
        process: {
            url: './upload',
            onerror: (response) => {
                serverMessage = JSON.parse(response)
            },
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf_token"]').content
            }
        }
    },
    labelFileProcessingError: () => {
        return serverMessage.error;
    }
});

const FilePond = vueFilepond(FilePondPluginFileValidationType, FilePondPluginFileValidateSize);

export default {
    components: {
        FilePond
    },
    data() {
        return {
            images: []
        }
    },
    mounted() {
      axios.get('/images')
          .then((response) => {
              this.images = response.data
          })
          .catch((error) => {
              console.log(error)
          });
    },
    methods: {
        filepondInitialize() {
            console.log('filepond ready', this.$refs.pond);
        },
        handleProcessedFile(error, file) {
            console.log('handleProcessedFile', file)
            if (error) {
                console.error(error);
                return;
            }

            this.images.unshift(file.serverId)
        }
    }
}
</script>
