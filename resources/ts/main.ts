/* eslint-disable import/order */
import '@/@fake-db/db'
import '@/@iconify/icons-bundle'
import App from '@/App.vue'
import ability from '@/plugins/casl/ability'
import layoutsPlugin from '@/plugins/layouts'
import vuetify from '@/plugins/vuetify'
import { loadFonts } from '@/plugins/webfontloader'
import router from '@/router'
import { abilitiesPlugin } from '@casl/vue'
import '@core-scss/template/index.scss'
import '@styles/styles.scss'
import { createPinia } from 'pinia'
import { createApp } from 'vue'
import type { VueQueryPluginOptions } from '@tanstack/vue-query'
import { VueQueryPlugin } from '@tanstack/vue-query'

loadFonts()

// Create vue app
const app = createApp(App)

const vueQueryPluginOptions: VueQueryPluginOptions = {
  queryClientConfig: {
    defaultOptions: {
      queries: {
        refetchOnWindowFocus: false,
        retry: 1,
      },
    },
  },
}

// Use plugins
app.use(vuetify)
app.use(createPinia())
app.use(router)
app.use(VueQueryPlugin, vueQueryPluginOptions)
app.use(layoutsPlugin)
app.use(abilitiesPlugin, ability, {
  useGlobalProperties: true,
})

// Mount vue app
app.mount('#app')
