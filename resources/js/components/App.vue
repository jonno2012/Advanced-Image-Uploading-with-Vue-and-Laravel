<template>
    <div class="mt-4">
        <file-pond
            name="image"
            ref="pond"
            label-idle="Click to choose image or drag here..."
            @init="filepondInitialize"
            accepted-file-types="image/*"
        />
    </div>
</template>

<script>
import vueFilepond, { setOptions } from "vue-filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginFileValidationType from 'filepond-plugin-file-validate-type';

setOptions({
    server: {
        process: {
            url: './upload',
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf_token"]').content
            }
        }
    }
});

const FilePond = vueFilepond(FilePondPluginFileValidationType);

export default {
    components: {
        FilePond
    },
    data() {
        return {}
    },
    methods: {
        filepondInitialize() {
            console.log('filepond ready', this.$refs.pond);
        }
    }
}
</script>
