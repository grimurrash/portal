<script setup lang="ts">
import { objectToOptions } from '@/utils/enums'
import { OrganizationProjectStatusNames } from '@/types/enums/organization-project-status.enum'

const emit = defineEmits(['update:filters'])

defineOptions({
  name: 'OrganizationProjectListFilters',
  inheritAttrs: false,
})

const selectStatus: Ref<number | undefined> = ref()
const dataRange = ref(``)

const selectFilter = computed<OrganizationProjectFilterDto>(function (): OrganizationProjectFilterDto {
  const dates = (dataRange.value ?? '').split(' to ')
  return {
    status: selectStatus.value,
    startDate: dates[0] ?? undefined,
    endDate: dates[1] ?? undefined,
  }
})

watch(selectFilter, () => {
  emit('update:filters', selectFilter.value)
})

const statusOptions = objectToOptions(OrganizationProjectStatusNames)
</script>

<template>
  <VCardText>
    <VRow>
      <VCol
        cols="12"
        sm="3"
      >
        <AppSelect
          v-model="selectStatus"
          :items="statusOptions"
          item-value="id"
          item-title="label"
          label="Статус"
          placeholder="Выбор статуса"
          clearable
          clear-icon="tabler-x"
        />
      </VCol>
      <VCol
        cols="12"
        sm="3"
      >
        <AppDateTimePicker
          v-model="dataRange"
          label="Промежуток проведения"
          placeholder="Выбор промежутка проведения"
          :config="{ mode: 'range' }"
        />
      </VCol>
    </VRow>
  </VCardText>
</template>

