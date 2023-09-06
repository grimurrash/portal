<script setup lang="tsx">
import { PerfectScrollbar } from 'vue3-perfect-scrollbar'
import { useTheme } from 'vuetify'
import { staticPrimaryColor } from '@/plugins/vuetify/theme'
import { useThemeConfig } from '@core/composable/useThemeConfig'
import { AppContentLayoutNav, ContentWidth, NavbarType } from '@layouts/enums'
import { themeConfig } from '@themeConfig'

// import { useTheme } from 'vuetify'

const isNavDrawerOpen = ref(false)

const {
  isVerticalNavCollapsed,
  isVerticalNavSemiDark,
  appContentWidth,
  appContentLayoutNav,
  isLessThanOverlayNavBreakpoint,
} = useThemeConfig()

// 👉 Primary Color
const vuetifyTheme = useTheme()

// const vuetifyThemesName = Object.keys(vuetifyTheme.themes.value)

const initialThemeColors = JSON.parse(JSON.stringify(vuetifyTheme.current.value.colors))
const colors = ['primary', 'secondary', 'success', 'info', 'warning', 'error']

// ℹ️ It will set primary color for current theme only
const setPrimaryColor = (color: string) => {
  const currentThemeName = vuetifyTheme.name.value

  vuetifyTheme.themes.value[currentThemeName].colors.primary = color

  // ℹ️ We need to store this color value in localStorage so vuetify plugin can pick on next reload
  localStorage.setItem(`${themeConfig.app.title}-${currentThemeName}ThemePrimaryColor`, color)

  // ℹ️ Update initial loader color
  localStorage.setItem(`${themeConfig.app.title}-initial-loader-color`, color)
}

/*
  ℹ️ This will return static color for first indexed color
  If we don't make first (primary) color as static then when another color is selected then we will have two theme colors with same hex codes and it will show two check marks
*/
const getBoxColor = (color: string, index: number) => index ? color : staticPrimaryColor

const { width: windowWidth } = useWindowSize()

const headerValues = computed(() => {
  const entries = Object.entries(NavbarType)

  if (appContentLayoutNav.value === AppContentLayoutNav.Horizontal)
    return entries.filter(([_, val]) => val !== NavbarType.Hidden)

  return entries
})
</script>

<template>
  <template v-if="!isLessThanOverlayNavBreakpoint(windowWidth)">
    <VBtn
      icon
      size="small"
      class="app-customizer-toggler rounded-s-lg rounded-0"
      style="z-index: 1001;"
      @click="isNavDrawerOpen = true"
    >
      <VIcon
        size="22"
        icon="tabler-settings"
      />
    </VBtn>

    <VNavigationDrawer
      v-model="isNavDrawerOpen"
      temporary
      border="0"
      location="end"
      width="400"
      :scrim="false"
      class="app-customizer"
    >
      <!-- 👉 Header -->
      <div class="customizer-heading d-flex align-center justify-space-between">
        <div>
          <h6 class="text-h6">
            НАСТРОЙКА ТЕМЫ
          </h6>
        </div>
        <IconBtn @click="isNavDrawerOpen = false">
          <VIcon
            icon="tabler-x"
            size="20"
          />
        </IconBtn>
      </div>

      <VDivider />

      <PerfectScrollbar
        tag="ul"
        :options="{ wheelPropagation: false }"
      >
        <!-- SECTION Theming -->
        <CustomizerSection
          title="ТЕМАТИЗАЦИЯ"
          :divider="false"
        >
          <!-- 👉 Primary color -->
          <!--  TODO: Перенести в настройки темы (позже добавим) -->
          <h6 class="mt-3 text-base font-weight-regular">
            Основной цвет
          </h6>
          <div class="d-flex gap-x-4 mt-2">
            <div
              v-for="(color, index) in colors"
              :key="color"
              style=" border-radius: 0.5rem; block-size: 2.5rem;inline-size: 2.5rem; transition: all 0.25s ease;"
              :style="{ backgroundColor: getBoxColor(initialThemeColors[color], index) }"
              class="cursor-pointer d-flex align-center justify-center"
              :class="{ 'elevation-4': vuetifyTheme.current.value.colors.primary === getBoxColor(initialThemeColors[color], index) }"
              @click="setPrimaryColor(getBoxColor(initialThemeColors[color], index))"
            >
              <VFadeTransition>
                <VIcon
                  v-show="vuetifyTheme.current.value.colors.primary === (getBoxColor(initialThemeColors[color], index))"
                  icon="tabler-check"
                  color="white"
                />
              </VFadeTransition>
            </div>
          </div>
        </CustomizerSection>
        <!-- !SECTION -->

        <!-- SECTION LAYOUT -->
        <!--  TODO: Перенести в настройки темы (позже добавим) -->
        <CustomizerSection title="МАКЕТ">
          <!-- 👉 Content Width -->
          <h6 class="text-base font-weight-regular">
            Ширина контента
          </h6>
          <VRadioGroup
            v-model="appContentWidth"
            inline
          >
            <VRadio
              v-for="[key, val] in Object.entries(ContentWidth)"
              :key="key"
              :label="key"
              :value="val"
            />
          </VRadioGroup>
        </CustomizerSection>
        <!-- !SECTION -->

        <!-- SECTION Menu -->
        <!--  TODO: Перенести в настройки темы (позже добавим) -->
        <CustomizerSection title="МЕНЮ">
          <!-- 👉 Menu Type -->
          <h6 class="text-base font-weight-regular">
            Тип меню
          </h6>
          <VRadioGroup
            v-model="appContentLayoutNav"
            inline
          >
            <VRadio
              v-for="[key, val] in Object.entries(AppContentLayoutNav)"
              :key="key"
              :label="key"
              :value="val"
            />
          </VRadioGroup>

          <!-- 👉 Collapsed Menu -->
          <!--  TODO: Перенести в настройки темы (позже добавим) -->
          <div
            v-if="appContentLayoutNav === AppContentLayoutNav.Vertical"
            class="mt-4 d-flex align-center justify-space-between"
          >
            <VLabel
              for="customizer-menu-collapsed"
              class="text-high-emphasis"
            >
              Collapsed Menu
            </VLabel>
            <div>
              <VSwitch
                id="customizer-menu-collapsed"
                v-model="isVerticalNavCollapsed"
                class="ms-2"
              />
            </div>
          </div>

          <!-- 👉 Semi Dark Menu -->
          <!--  TODO: Перенести в настройки темы (позже добавим) -->
          <div
            class="mt-4 align-center justify-space-between"
            :class="vuetifyTheme.global.name.value === 'light' && appContentLayoutNav === AppContentLayoutNav.Vertical ? 'd-flex' : 'd-none'"
          >
            <VLabel
              for="customizer-menu-semi-dark"
              class="text-high-emphasis"
            >
              Semi Dark Menu
            </VLabel>
            <div>
              <VSwitch
                id="customizer-menu-semi-dark"
                v-model="isVerticalNavSemiDark"
                class="ms-2"
              />
            </div>
          </div>
        </CustomizerSection>
        <!-- !SECTION -->
      </PerfectScrollbar>
    </VNavigationDrawer>
  </template>
</template>

<style lang="scss">
.app-customizer {
  .customizer-section {
    padding: 1.25rem;
  }

  .customizer-heading {
    padding-block: 0.875rem;
    padding-inline: 1.25rem;
  }

  .v-navigation-drawer__content {
    display: flex;
    flex-direction: column;
  }
}

.app-customizer-toggler {
  position: fixed !important;
  inset-block-start: 50%;
  inset-inline-end: 0;
}
</style>
