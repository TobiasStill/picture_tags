import {api} from "./api-service";
import Vuex from "../vendor/vuex.js"

export const store = new Vuex.Store({
    state: {
        currentTags: [],
        images: [],
        currentImage: null,
        author: ''
    },
    mutations: {
        tags: (state, tags) => {
            state.currentTags = tags;
        },
        tag: (state, tag) => {
            const index = state.tags.findIndex(p => p._id === tag._id);
            if (index > -1) {
                state.currentTags[index] = tag;
                // array needs to be recreated otherwise state won't notify changes
                state.currentTags = [...state.currentTags];
            } else {
                throw Error('Tag does not exist');
            }
        },
        images: (state, images) => {
            state.images = images;
            state.currentImage = images[0];
        },
        currentImage: (state, image) => {
             state.currentImage = image;
        }
    },
    getters: {
        findTag: (state) => (key) => {
            return state.tags.find(p => p.id === key);
        },
        findTagsOfImage: (state) => (key) => {
            return state.tags.filter(t => t.images.indexOf(key)>=0);
        },
        nextImage: (state) => () => {
            if(! state.currentImage) {
                return state.images[0];
            }
            let i = state.images.indexOf(state.currentImage);
            i = (i + 1) % state.images.length;
            return state.images[i];
        },
        previousImage: (state) => () => {
            if(! state.currentImage) {
                return state.images[0];
            }
            let i = state.images.indexOf(state.currentImage);
            i = (i - 1) % state.images.length;
            if(i < 0) {
                i = state.length -i;
            }
            return state.images[i];
        },
    },
    actions: {
        loadCurrentImageAndTags: ({state, commit}) => {
            return api.fetchImages()
                .then((images) => {
                    commit('images', images);
                });
        },
        loadImages: ({state, commit}) => {
            return api.fetchImages()
                .then((images) => {
                    commit('images', images);
                });
        },
        loadTags: ({commit}) => {
            return api.fetchTags()
                .then((tags) => {
                    commit('tags', tags);
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
        nextImage: ({commit, getters}) => {
            const next = getters.nextImage();
            commit('currentImage', next);
        },
        previousImage: ({commit, getters}) => {
            const previous = getters.previousImage();
            commit('currentImage', previous);
        },
    }
});
