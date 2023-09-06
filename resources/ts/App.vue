<script setup lang="ts">
import { useTheme } from 'vuetify'
import ScrollToTop from '@core/components/ScrollToTop.vue'
import { useThemeConfig } from '@core/composable/useThemeConfig'
import { hexToRgb } from '@layouts/utils'
import { useAuthStore } from '@/store/useAuthStore'
import { useNotificationStore } from '@/store/useNotificationStore'

const { syncInitialLoaderTheme, syncVuetifyThemeWithTheme: syncConfigThemeWithVuetifyTheme, isAppRtl, handleSkinChanges } = useThemeConfig()
const userData = localStorage.getItem('userData')
if (userData) {
  const authStore = useAuthStore()
  authStore.setUserData(JSON.parse(userData))
}
const { global } = useTheme()

const notificationStore = useNotificationStore()
const { errorMessage, isSnackbarVisible } = storeToRefs(notificationStore)
// ℹ️ Sync current theme with initial loader theme
syncInitialLoaderTheme()
syncConfigThemeWithVuetifyTheme()
handleSkinChanges()
</script>

<template>
  <VLocaleProvider :rtl="isAppRtl">
    <!-- ℹ️ This is required to set the background color of active nav link based on currently active global theme's primary -->
    <VApp :style="`--v-global-theme-primary: ${hexToRgb(global.current.value.colors.primary)}`">
      <RouterView />
      <ScrollToTop />
    </VApp>
    <VSnackbar
      v-model="isSnackbarVisible"
      transition="scale-transition"
      location="top end"
      variant="flat"
      color="error"
      :timeout="2000"
    >
      {{ errorMessage }}
    </VSnackbar>
  </VLocaleProvider>
</template>
