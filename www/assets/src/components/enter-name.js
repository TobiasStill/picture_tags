import Vue from "../vendor/vue";


export const EnterName = Vue.component('enter-name', {
    components: {},
    data: {
        name: '',
    errors: []},
    computed: {
    },
    methods: {
        submit: function () {
            this.errors = [];
            if(! this.name) {
                this.errors.push('Please enter your Name!')
            } else {

            }
        },
    },
    template: `
      <section class="form">
      <div class="field">
        <label class="label">Please enter your name</label>
        <div class="control">
          <input v-model="name" required class="input" type="text" placeholder="Text input">
        </div>
        <div class="control">
          <button :disabled="errors.length" @click="showExhibit(exhibit.id)">
            Submit
          </button>
        </div>
      </div>
      </section>
    `
});
