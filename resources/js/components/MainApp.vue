<template>
    <div id="main-app">
        <chat-app-component></chat-app-component>
    </div>
</template>

<script>
    import chatAppComponent from './ChatApp'
    export default {
        name: "MainApp",
        components:{
            chatAppComponent
        },
    }
</script>

<style scoped>

</style>