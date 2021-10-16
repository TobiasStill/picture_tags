import {store} from "./services/store.js";
import Vue from "./vendor/vue";
import {router} from "./services/router";

const showCurrentImage = (key) => {
    return store.dispatch('setCurrentImageAndTags', key);
};

const handleRoute = () => {
    // get current route parameters
    const currentImage = router.getCurrentImage();
    if (currentImage) {
        showCurrentImage(currentImage)
    }
};

// component

window.app = new Vue({
    store,
    el: '#picture-tag',
    components: {EnterName, Header, Footer},
    computed: {
        currentImage: function () {
            return this.$store.state.currentImage;
        },
        currentTags: function () {
            return this.$store.state.currentTags;
        },
        images: function () {
            return this.$store.state.images;
        },
    },
    init: function () {
        Promise.all([this.$store.dispatch('loadImages', {}),
            this.$store.dispatch('loadTags', {})]).then(() => {
            router.subscribe(handleRoute);
        });
    },
    watch: {}
});

