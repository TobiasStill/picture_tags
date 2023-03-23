<script setup lang="ts">
import ImageInventory from '@/components/ImageInventory.vue';
import {useImageStore} from '@/stores/imageStore';
const store = useImageStore();
const {images} = store;
</script>

<template>
  <main>
    <ImageInventory :images="images"/>
  </main>
</template>
