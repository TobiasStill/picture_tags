<script setup lang="ts">
import Image from '@/components/Image.vue';

defineProps<{
  images: Image[]
}>()
</script>

<template>
<ul>
  <li v-for="image in images">
    <Image :image="image"></Image>
  </li>
</ul>
</template>

<style scoped>

</style>
