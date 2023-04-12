<template>
    <div class="mt-4">
        <file-pond
            name="image"
            ref="pond"
            label-idle="Click to choose image or drag here..."
            server="/upload"
            @init="filepondInitialize"
            accepted-file-types="image/*"
        />
    </div>
</template>

<script>
import vueFilepond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import FilePondPluginFileValidationType from 'filepond-plugin-file-validate-type';

const FilePond = vueFilepond(FilePondPluginFileValidationType);

export default {
    components: {
        FilePond
    },
    data() {
        return {
        }
    },
    methods: {
        filepondInitialize() {
            console.log('filepond ready', this.$refs.pond);
        }
    }
}
</script>
