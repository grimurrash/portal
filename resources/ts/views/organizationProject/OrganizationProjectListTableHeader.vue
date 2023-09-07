<script setup lang="ts">

interface Props {
  options: TableOptions
}

defineProps<Props>()

defineOptions({
  name: 'OrganizationProjectListTableHeader',
  inheritAttrs: false,
})
</script>

<template>
  <VCardText class="d-flex flex-wrap py-4 gap-4">
    <div class="me-3 d-flex gap-3">
      <AppSelect
        :model-value="options.itemsPerPage"
        :items="[
                  { value: 9, title: '9' },
                  { value: 12, title: '12' },
                  { value: 21, title: '21' },
                  { value: 30, title: '30' },
                ]"
        style="width: 6.25rem;"
        @update:model-value="options.itemsPerPage = parseInt($event, 10)"
      />
    </div>
    <div class="d-flex align-end">
      <slot name="paginate-meta">

      </slot>
    </div>
    <VSpacer/>
    <div class="app-user-search-filter gap-4">
      <TableSearchInput
        v-model="options.search"
        placeholder="Поиск по названию проекта"
      />
    </div>
    <slot name="actions">

    </slot>
  </VCardText>
</template>

