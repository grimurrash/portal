<script setup lang="ts">
import {
  OrganizationProjectStatusEnum,
  OrganizationProjectStatusNames
} from '@/types/enums/organization-project-status.enum'

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

const statusOptions = [
  { value: OrganizationProjectStatusEnum.CREATE, title: OrganizationProjectStatusNames[OrganizationProjectStatusEnum.CREATE] },
  { value: OrganizationProjectStatusEnum.MODERATION, title: OrganizationProjectStatusNames[OrganizationProjectStatusEnum.MODERATION] },
  { value: OrganizationProjectStatusEnum.APPROVE, title: OrganizationProjectStatusNames[OrganizationProjectStatusEnum.APPROVE] },
  { value: OrganizationProjectStatusEnum.FINISH, title: OrganizationProjectStatusNames[OrganizationProjectStatusEnum.FINISH] },
  { value: OrganizationProjectStatusEnum.CANCEL, title: OrganizationProjectStatusNames[OrganizationProjectStatusEnum.CANCEL] },
]
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

