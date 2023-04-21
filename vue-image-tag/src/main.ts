import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { plugin as formkitPlugIn, defaultConfig as formkitConfig} from '@formkit/vue'
import '@formkit/themes/genesis'

import App from './App.vue'
import router from './router'

import './assets/main.css'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.use(formkitPlugIn, formkitConfig)

app.mount('#app')
