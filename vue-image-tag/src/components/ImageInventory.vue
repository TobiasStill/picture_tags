<script setup lang="ts">
import Image from '@/components/Image.vue';

defineProps<{
  images: Image[],
}>()

const handleSubmit = (i: Image) => {
 alert(i.caption);
}
</script>

<template>
<ul>
  <li v-for="image in images">
    <Image :image="image"></Image>

      <FormKit
          type="form"
          #default="{ value }"
          @submit="handleSubmit"
          :value="image"
      >
        <FormKit
            type="text"
            label="Caption"
            name="caption"
            placeholder="caption"
            help="Image Caption"
        />
      </FormKit>
  </li>
</ul>
</template>

<style scoped>
/deep/ img {width: 300px}
ul,
li{
  padding: 0;
  list-style: none;
}
li{
  display:flex;
}
</style>
