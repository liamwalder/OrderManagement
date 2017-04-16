<template>
    <div class="errors">
        <div v-for="error in errors">
            <p v-for="message in error">{{ message }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            errors: null
        }
    }
</script>
