<script setup lang="ts">
import { useQuery } from '@tanstack/vue-query'
import { DepartmentService } from '@/services/management/department.service'

interface Props {
  modelValue: number | undefined | null
  isEnabled: boolean
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: null,
  isEnabled: false,
})

const emit = defineEmits(['update:modelValue'])

defineOptions({
  name: 'ALlDepartmentSelect',
  inheritAttrs: false,
})

const { data: queryResult } = useQuery({
  queryKey: ['departments', 'all-options'],
  queryFn: () => DepartmentService.allDepartmentOptions(),
  enabled: props.isEnabled,
  staleTime: 1000 * 60,
})

const options = computed((): DepartmentOptionItemModel[] => queryResult.value?.data ?? [])

const label = computed(() => useAttrs().label as string | 'Родительский отдел')

const selectValue = ref(props.modelValue)

watch([props], () => {
  selectValue.value = props.modelValue
})
watch([selectValue], () => {
  emit('update:modelValue', selectValue)
})
</script>

<template>
  <AppSelect
    v-model="selectValue"
    :label="label"
    :items="options"
    item-value="id"
    item-title="name"
    v-bind="{
      ...$attrs,
    }"
    clearable
  />
</template>
