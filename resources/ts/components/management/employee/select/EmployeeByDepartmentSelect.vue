<script setup lang="ts">
import { useQuery } from '@tanstack/vue-query'
import { EmployeeService } from '@/services/management/employees.service'

interface Props {
  modelValue: number | undefined | null
  departmentId: number | undefined | null
  isEnabled: boolean
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: null,
  isEnabled: false,
  departmentId: null,
})

const emit = defineEmits(['update:modelValue'])

defineOptions({
  name: 'EmployeeByDepartment',
  inheritAttrs: false,
})

const { data: queryResult } = useQuery({
  queryKey: ['employees', 'options-by-department', { department_id: props.departmentId }],
  queryFn: () => {
    if (props.departmentId === null)
      return

    return EmployeeService.employeesOptionsByDepartmentId(props.departmentId)
  },
  enabled: props.isEnabled && !!props.departmentId,
  staleTime: 1000 * 60,
})

const options = computed((): EmployeeOptionItemModel[] => queryResult.value?.data ?? [])

const label = computed(() => useAttrs().label as string | 'Сотрудник отдела')

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
