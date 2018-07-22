<template>
    <div class="container">
        <transition name="fade">
            <router-view></router-view>     
        </transition>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Componente montado');  
        }
    }
</script>
