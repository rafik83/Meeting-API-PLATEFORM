<script>
    import {_} from 'svelte-i18n';

    export let accept;
    export let maxSize;

    let values = {
        file: '',
    };

    let acceptedFiles = [];
    let fileRejections = [];

    function inputFile(e) {
        const files = e.target.files;
        Object.keys(files).map((file) => {
            if(files[file].size > 1048576) {
                fileRejections.push(files[file].name);
            } else {
                acceptedFiles.push(files[file].name);
            }
        });
    }
</script>

<div>
<h1 class="underline font-semibold">{$_('registration.upload_logo')}</h1>
<h2 class="text-community-300 text-sm">{$_('registration.png_jpg')}</h2>
<input
        {accept}
        type="file"
        autocomplete="off"
        {maxSize}
        on:change={inputFile}
        bind:value={values.file}
/>
</div>