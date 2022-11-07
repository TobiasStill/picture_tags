import {api} from "./api-service";
import Vuex from "../vendor/vuex.js"

export const store = new Vuex.Store({
    state: {
        images: [],
        author: '',
        tagListing: []
    },
    mutations: {
        author: (state, author) => {
             state.author = author;
        },
        images: (state, images) => {
            state.images = images;
        },
        tagListing: (state, listing) => {
            state.tagListing = listing;
        },
        tag: (state, tagData) => {
            const index = state.tagListing.findIndex(t => t.name === tagData.name);
            if(index >= 0) {
                const {images} = tagData;
                const previous = state.tagListing[index];
                state.tagListing[index] = {...previous, images}
            }
        }
    },
    getters: {
        getImageTagListing: (state) => (name) => {
            return state.tagListing.filter(t => t.images.indexOf(name)>=0);
        },
        findImage: (state) => (name) => {
            return state.images.find(p => p.name === name);
        },
        nextImage: (state) => (currentImage) => {
            if(! currentImage) {
                return state.images[0];
            }
            let i = state.images.indexOf(currentImage);
            i = (i + 1) % state.images.length;
            return state.images[i];
        },
        previousImage: (state) => (currentImage) => {
            if(! currentImage) {
                return state.images[0];
            }
            let i = state.images.indexOf(currentImage);
            i = (i - 1) % state.images.length;
            if(i < 0) {
                i = state.length -i;
            }
            return state.images[i];
        },
    },
    actions: {
        loadImages: ({state, commit}) => {
            return api.fetchImages()
                .then((images) => {
                    commit('images', images);
                });
        },
        loadTagListing: ({commit}) => {
            return api.fetchTagListing()
                .then((tags) => {
                    commit('tagListing', tags);
                });
        },
        putTag: ({commit}, tagData) => {
            return api.putTag(tagData)
                .then((tag) => {
                    commit('tag', tag);
                });
        },
        tagImage: ({commit}, image, tag) => {
            const clone = JSON.parse(JSON.stringify(tag));
            clone.images = Array.from(new Set([...clone.images, tag.name]));
            return api.putTag(clone)
                .then((update) => {
                    commit('tag', update);
                });
        },
        untagImage: ({commit}, image, tag) => {
            const clone = JSON.parse(JSON.stringify(tag));
            clone.images = clone.images.filter(name => name !== image.name);
            return api.putTag(clone)
                .then((update) => {
                    commit('tag', update);
                });
        },
        addNote: ({state, commit}, note, tag) => {
            if(!state.author) {
                throw Error('No author');
            }
            const clone = JSON.parse(JSON.stringify(tag));
            clone.notes.push({note, author: state.author, date: Date.now()});
            return api.putTag(clone)
                .then((update) => {
                    commit('tag', update);
                });
        },
        postTag: ({commit}, tagData) => {
            return api.postTag(tagData)
                .then((tag) => {
                    commit('tag', tag);
                });
        },
    }
});
