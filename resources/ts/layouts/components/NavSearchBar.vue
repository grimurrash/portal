<script setup lang="ts">
import Shepherd from 'shepherd.js'
import type { SearchHeader, SearchItem } from '@/@fake-db/types'
import axios from '@axios'
import { useThemeConfig } from '@core/composable/useThemeConfig'

interface Suggestion {
  icon: string
  title: string
  url: object
}

const { appContentLayoutNav } = useThemeConfig()

interface SuggestionGroup {
  title: string
  content: Suggestion[]
}

defineOptions({
  inheritAttrs: false,
})

// 👉 Is App Search Bar Visible
const isAppSearchBarVisible = ref(false)

// 👉 Default suggestions
const suggestionGroups: SuggestionGroup[] = [
  {
    title: 'Popular Searches',
    content: [
      { icon: 'tabler-chart-donut', title: 'Analytics', url: { name: 'demo-dashboards-analytics' } },
      { icon: 'tabler-chart-bubble', title: 'CRM', url: { name: 'demo-dashboards-crm' } },
      { icon: 'tabler-file', title: 'Invoice List', url: { name: 'demo-apps-invoice-list' } },
      { icon: 'tabler-users', title: 'User List', url: { name: 'demo-apps-user-list' } },
    ],
  },
  {
    title: 'Apps & Pages',
    content: [
      { icon: 'tabler-calendar', title: 'Calendar', url: { name: 'demo-apps-calendar' } },
      { icon: 'tabler-file-plus', title: 'Invoice Add', url: { name: 'demo-apps-invoice-add' } },
      { icon: 'tabler-currency-dollar', title: 'Pricing', url: { name: 'demo-pages-pricing' } },
      {
        icon: 'tabler-user',
        title: 'Account Settings',
        url: { name: 'demo-pages-account-settings-tab', params: { tab: 'account' } },
      },
    ],
  },
  {
    title: 'User Interface',
    content: [
      { icon: 'tabler-letter-a', title: 'Typography', url: { name: 'demo-pages-typography' } },
      { icon: 'tabler-square', title: 'Tabs', url: { name: 'demo-components-tabs' } },
      { icon: 'tabler-hand-click', title: 'Buttons', url: { name: 'demo-components-button' } },
      { icon: 'tabler-keyboard', title: 'Statistics', url: { name: 'demo-pages-cards-card-statistics' } },
    ],
  },
  {
    title: 'Popular Searches',
    content: [
      { icon: 'tabler-list', title: 'Select', url: { name: 'demo-forms-select' } },
      { icon: 'tabler-space', title: 'Combobox', url: { name: 'demo-forms-combobox' } },
      { icon: 'tabler-calendar', title: 'Date & Time Picker', url: { name: 'demo-forms-date-time-picker' } },
      { icon: 'tabler-hexagon', title: 'Rating', url: { name: 'demo-forms-rating' } },
    ],
  },
]

// 👉 No Data suggestion
const noDataSuggestions: Suggestion[] = [
  {
    title: 'Analytics Dashboard',
    icon: 'tabler-shopping-cart',
    url: { name: 'demo-dashboards-analytics' },
  },
  {
    title: 'Account Settings',
    icon: 'tabler-user',
    url: { name: 'demo-pages-account-settings-tab', params: { tab: 'account' } },
  },
  {
    title: 'Pricing Page',
    icon: 'tabler-cash',
    url: { name: 'demo-pages-pricing' },
  },
]

const searchQuery = ref('')
const searchResult = ref<(SearchItem | SearchHeader)[]>([])
const router = useRouter()

// 👉 fetch search result API
watchEffect(() => {
  axios.get('/app-bar/search', {
    params: {
      q: searchQuery.value,
    },
  }).then(response => {
    searchResult.value = response.data
  })
})

// 👉 redirect the selected page
const redirectToSuggestedOrSearchedPage = (selected: Suggestion) => {
  router.push(selected.url)

  isAppSearchBarVisible.value = false
  searchQuery.value = ''
}

const LazyAppBarSearch = defineAsyncComponent(() => import('@core/components/AppBarSearch.vue'))
</script>

<template>
  <div
    class="d-flex align-center cursor-pointer"
    v-bind="$attrs"
    style="user-select: none;"
    @click="isAppSearchBarVisible = !isAppSearchBarVisible"
  >
    <!-- 👉 Search Trigger button -->
    <!-- close active tour while opening search bar using icon -->
    <IconBtn
      class="me-1"
      @click="Shepherd.activeTour?.cancel()"
    >
      <VIcon
        size="26"
        icon="tabler-search"
      />
    </IconBtn>

    <span
      v-if="appContentLayoutNav === 'vertical'"
      class="d-none d-md-flex align-center text-disabled"
      @click="Shepherd.activeTour?.cancel()"
    >
      <span class="me-3">Search</span>
      <span class="meta-key">&#8984;K</span>
    </span>
  </div>

  <!-- 👉 App Bar Search -->
  <LazyAppBarSearch
    v-model:isDialogVisible="isAppSearchBarVisible"
    v-model:search-query="searchQuery"
    :search-results="searchResult"
    :suggestions="suggestionGroups"
    :no-data-suggestion="noDataSuggestions"
    @item-selected="redirectToSuggestedOrSearchedPage"
  >
    <!--
      <template #suggestions>
      use this slot if you want to override default suggestions
      </template>
    -->

    <!--
      <template #noData>
      use this slot to change the view of no data section
      </template>
    -->

    <!--
      <template #searchResult="{ item }">
      use this slot to change the search item
      </template>
    -->
  </LazyAppBarSearch>
</template>

<style lang="scss" scoped>
@use "@styles/variables/_vuetify.scss";

.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 6px;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}
</style>
