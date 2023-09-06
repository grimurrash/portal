<script setup lang="ts">
import { VForm } from 'vuetify/components/VForm'
import { integerValidator, requiredValidator } from '@validators'

defineOptions({
  name: 'OrganizationProjectCard',
  inheritAttrs: false,
})

interface Props {
  projectData: CreateOrganizationProjectRequestDto | UpdateOrganizationProjectRequestDto
  errors: Record<string, string>
}

interface Emit {
  (e: 'submitForm'): void
}

defineProps<Props>()
const emit = defineEmits<Emit>()
const onFormSubmit = (event: Event) => {
  event.preventDefault()
  emit('submitForm')
}
const validate = () => {
  return refForm.value?.validate().then(({valid: isValid}) => {
    if (isValid) {
      return
    }
    throw new Error('Invalid form')
  })
}
defineExpose({ validate })

const refForm = ref<VForm>()
</script>

<template>
  <VForm
    class="mt-6"
    ref="refForm"
    @submit.prevent="onFormSubmit"
  >
    <VRow>
      <VCol cols="12" sm="6" md="6">
        <AppTextField
          v-model="projectData.number"
          persistent-placeholder
          type="number"
          label="№ согласно календарному плану"
          placeholder="№ согласно календарному плану"
          :error-messages="errors.number"
          :rules="[requiredValidator, integerValidator]"
        />
      </VCol>
      <VCol cols="12" sm="6" md="6">
        <AppTextField
          v-model="projectData.name"
          label="Наименование проекта"
          placeholder="Наименование проекта"
          :error-messages="errors.name"
          :rules="[requiredValidator]"
        />
      </VCol>
      <VCol cols="12">
        <AppTextarea
          v-model="projectData.description"
          label="Описание проекта"
          placeholder="Описание проекта"
          :error-messages="errors.description"
          :rules="[requiredValidator]"
          rows="2"
          auto-grow
        />
      </VCol>
      <VCol cols="12">
        <AppTextarea
          v-model="projectData.metrics"
          label="Ключевые показатели"
          placeholder="Ключевые показатели"
          :error-messages="errors.metrics"
          :rules="[requiredValidator]"
          rows="2"
          auto-grow
        />
      </VCol>

      <VCol cols="12" sm="6" md="6">
        <AppTextField
          v-model="projectData.planned_coverage"
          persistent-placeholder
          type="number"
          label="Планируемый охват участников"
          placeholder="Планируемый охват участников"
          :error-messages="errors.planned_coverage"
          :rules="[requiredValidator, integerValidator]"
        />
      </VCol>
      <VCol cols="12" sm="6" md="6">
        <AppTextField
          v-model="projectData.actual_coverage"
          persistent-placeholder
          type="number"
          label="Фактический охват участников"
          placeholder="Фактический охват участников"
          :error-messages="errors.actual_coverage"
          :rules="[requiredValidator, integerValidator]"
        />
      </VCol>
      <VCol cols="12" sm="6" md="6">
        <UserSelect
          v-model="projectData.curator_user_id"
          persistent-placeholder
          label="Куратор"
          placeholder="Куратор"
          :rules="[requiredValidator]"
        />
      </VCol>
      <VCol cols="12" sm="6" md="6">
        <UserSelect
          v-model="projectData.responsible_user_id"
          persistent-placeholder
          label="Ответственный"
          placeholder="Ответственный"
          :rules="[requiredValidator]"
        />
      </VCol>

      <VCol cols="12" sm="6" md="6">
        <AppDateTimePicker
          v-model="projectData.start_date"
          label="Дата начала"
          placeholder="Дата начала"
          :error-messages="errors.start_date"
          :rules="[requiredValidator]"
        />
      </VCol>
      <VCol cols="12" sm="6" md="6">
        <AppDateTimePicker
          v-model="projectData.end_date"
          label="Дата окончания"
          placeholder="Дата окончания"
          :error-messages="errors.end_date"
          :rules="[requiredValidator]"
        />
      </VCol>
      <VCol cols="12">
        <OrganizationProjectDateList v-model:items="projectData.dates" :is-read-only="false"/>
      </VCol>
      <VCol>
        <VBtn
          prepend-icon="tabler-plus"
          @click="projectData.dates.push({name: '', date: null})"
        >
          Добавить контрольную точку
        </VBtn>
      </VCol>
    </VRow>
  </VForm>
</template>
