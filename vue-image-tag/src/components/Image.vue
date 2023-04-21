<script setup lang="ts">
import type {Image} from '@/api/imageApi';

defineProps<{
  image: Image
}>()
</script>

<template>
  <figure>
    <img
        :srcset="image.srcSet"
        sizes="(max-width: 600px) 480px,
         800px"
        :src="image.src"
        :alt="image.caption" />
    <figcaption>{{image.caption}}</figcaption>
  </figure>
</template>

<style scoped>

</style>
