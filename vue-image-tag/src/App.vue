<script setup lang="ts">
import { RouterView } from 'vue-router'
import PtHeader from '@/components/PtHeader.vue';
import PtFooter from '@/components/PtFooter.vue';
</script>

<template>

  <PtHeader></PtHeader>
  <RouterView />
  <PtFooter content="Copy Tobias Still"></PtFooter>
</template>

<style scoped>

</style>
