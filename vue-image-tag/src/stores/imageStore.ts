import {defineStore} from 'pinia'
import {imageApi} from '@/api/imageApi';
import type {Image} from '@/api/imageApi';
import {ref, computed} from 'vue';
import type {Ref, UnwrapRef} from 'vue';

export const useImageStore = defineStore('images', () => {
    const images: Ref<UnwrapRef<Image[]>> = ref([]);

    async function fetchImages() {
        try {
            const img = await imageApi.fetchImages();
            images.value = img
        } catch (error) {
            // let the form component display the error
            return error
        }
    }

    return {images:computed((name) => images.value), fetchImages}
})
