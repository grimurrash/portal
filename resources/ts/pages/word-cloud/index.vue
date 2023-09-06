<script setup lang="ts">
import { VDataTableServer } from 'vuetify/labs/VDataTable'
import { paginationMeta } from '@/utils/utils'
import type { Options } from '@core/types'
import { useWordCloudStore } from '@/views/word-cloud/useWordCloudStore'
import type { WordCloudProperties } from '@/db/types'
import DeleteDialog from '@/views/users/components/dialogs/DeleteDialog.vue'
import AddNewWordCloudDrawer from '@/views/word-cloud/compoments/drawers/AddNewWordCloudDrawer.vue'
import EditWordCloudDrawer from '@/views/word-cloud/compoments/drawers/EditWordCloudDrawer.vue'

// 👉 Store
const wordCloudStore = useWordCloudStore()
const searchQuery = ref('')
const totalPages = ref(1)
const totalWordClouds = ref(0)
const wordClouds = ref<WordCloudProperties[]>([])
const isAddNewWordCloudDrawerVisible = ref(false)
const isWordCloudEditDrawerVisible = ref(false)
const isWordCloudDeleteDialogVisible = ref(false)
const selectedWordCloud = ref()

const options = ref<Options>({
  page: 1,
  itemsPerPage: 10,
  sortBy: [],
  groupBy: [],
  search: undefined,
})

// Headers
const headers = [
  { title: 'МЕРОПРИЯТИЕ', key: 'event' },
  { title: 'ВОПРОС', key: 'question' },
  { title: 'СОЗДАТЕЛЬ', key: 'creator' },
  { title: 'ССЫЛКА НА ОБЛАКО СЛОВ', key: 'cloudLink', sortable: false },
  { title: 'ССЫЛКА НА ФОРМУ ВОПРОСА', key: 'questionLink', sortable: false },
  { title: 'КОЛ-ВО ОТВЕТОВ', key: 'numberOfResponses' },
  { title: 'ДЕЙСТВИЯ', key: 'actions', sortable: false },
]

// 👉 Fetching users
const fetchWordClouds = () => {
  const response = wordCloudStore.fetchWordClouds({
    q: searchQuery.value,
    options: options.value,
  })

  wordClouds.value = response.wordClouds
  totalPages.value = response.totalPages
  totalWordClouds.value = response.totalWordClouds
  options.value.page = response.page
}

// 👉 Add new user
const addNewWordCloud = (wordCloudData: WordCloudProperties) => {
  wordCloudStore.addWordCloud(wordCloudData)

  // refetch word cloud
  fetchWordClouds()
}

// 👉 Delete user
const deleteWordCloud = (wordCloud: WordCloudProperties) => {
  isWordCloudDeleteDialogVisible.value = true
  selectedWordCloud.value = wordCloud
}

const deleteWordCloudConfirm = () => {
  wordCloudStore.deleteWordCloud(selectedWordCloud.value)

  // refetch word cloud
  fetchWordClouds()
}

const editWordCloud = (wordCloud: WordCloudProperties) => {
  isWordCloudEditDrawerVisible.value = true
  selectedWordCloud.value = wordCloud
}

watchEffect(fetchWordClouds)
</script>

<template>
  <section>
    <VRow>
      <VCol cols="12">
        <VCard>
          <VCardText class="d-flex flex-wrap py-4 gap-4">
            <div class="me-3 d-flex gap-3">
              <AppSelect
                :model-value="options.itemsPerPage"
                :items="[
                  { value: 10, title: '10' },
                  { value: 25, title: '25' },
                  { value: 50, title: '50' },
                  { value: 100, title: '100' },
                  { value: -1, title: 'All' },
                ]"
                style="width: 6.25rem;"
                @update:model-value="options.itemsPerPage = parseInt($event, 10)"
              />
            </div>
            <VSpacer />

            <div class="app-user-search-filter d-flex align-center flex-wrap gap-4">
              <!-- 👉 Search  -->
              <div style="inline-size: 20rem;">
                <AppTextField
                  v-model="searchQuery"
                  placeholder="Поиск"
                  density="compact"
                />
              </div>

              <!-- 👉 Add cloud button -->
              <VBtn @click="isAddNewWordCloudDrawerVisible = true">
                Добавить
              </VBtn>
            </div>
          </VCardText>

          <VDivider />

          <!-- SECTION datatable -->
          <VDataTableServer
            v-model:items-per-page="options.itemsPerPage"
            v-model:page="options.page"
            :items="wordClouds"
            :items-length="totalWordClouds"
            :headers="headers"
            class="text-no-wrap"
            @update:options="options = $event"
          >
            <!-- Actions -->
            <template #item.actions="{ item }">
              <VBtn
                icon
                variant="text"
                size="small"
                color="medium-emphasis"
              >
                <VIcon
                  size="24"
                  icon="tabler-dots-vertical"
                />

                <VMenu activator="parent">
                  <VList>
                    <VListItem @click="editWordCloud(item.raw)">
                      <template #prepend>
                        <VIcon icon="tabler-pencil" />
                      </template>
                      <VListItemTitle>Редактировать</VListItemTitle>
                    </VListItem>

                    <VListItem link>
                      <template #prepend>
                        <VIcon icon="tabler-pencil" />
                      </template>
                      <VListItemTitle>Экспорт ответов(excel)</VListItemTitle>
                    </VListItem>

                    <VListItem link>
                      <template #prepend>
                        <VIcon icon="tabler-pencil" />
                      </template>
                      <VListItemTitle>Экспорт ответов(google)</VListItemTitle>
                    </VListItem>

                    <VListItem link>
                      <template #prepend>
                        <VIcon icon="tabler-trash" />
                      </template>
                      <VListItemTitle>Очистить</VListItemTitle>
                    </VListItem>

                    <VListItem @click="deleteWordCloud(item.raw.id)">
                      <template #prepend>
                        <VIcon icon="tabler-trash" />
                      </template>
                      <VListItemTitle>Удалить</VListItemTitle>
                    </VListItem>
                  </VList>
                </VMenu>
              </VBtn>
            </template>

            <!-- pagination -->
            <template #bottom>
              <VDivider />
              <div class="d-flex align-center justify-sm-space-between justify-center flex-wrap gap-3 pa-5 pt-3">
                <p class="text-sm text-disabled mb-0">
                  {{ paginationMeta(options, totalWordClouds) }}
                </p>

                <VPagination
                  v-model="options.page"
                  :length="Math.ceil(totalWordClouds / options.itemsPerPage)"
                  :total-visible="$vuetify.display.xs ? 1 : Math.ceil(totalWordClouds / options.itemsPerPage)"
                />
              </div>
            </template>
          </VDataTableServer>
          <!-- SECTION -->
        </VCard>

        <!-- 👉 Add new word cloud drawer -->
        <AddNewWordCloudDrawer
          v-model:isDrawerOpen="isAddNewWordCloudDrawerVisible"
          @word-cloud-data="addNewWordCloud"
        />
        <!--  👉 Edit word cloud drawer -->
        <EditWordCloudDrawer
          v-model:isDrawerOpen="isWordCloudEditDrawerVisible"
          :word-cloud-data="selectedWordCloud"
          @submit="editWordCloud"
        />
        <!--  👉 Delete user dialog -->
        <DeleteDialog
          v-model:isDialogVisible="isWordCloudDeleteDialogVisible"
          @confirm="deleteWordCloudConfirm"
        />
      </vcol>
    </vrow>
  </section>
</template>

<style lang="scss">
.app-user-search-filter {
  inline-size: 31.6rem;
}

.text-capitalize {
  text-transform: capitalize;
}

.user-list-name:not(:hover) {
  color: rgba(var(--v-theme-on-background), var(--v-medium-emphasis-opacity));
}
</style>
