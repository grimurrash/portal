<script setup lang="ts">
import { useQuery } from '@tanstack/vue-query'
import { UserService } from '@/services/management/user.service'
import SearchSelect from '@/components/SearchSelect.vue'

interface Props {
  modelValue: number | null
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: null,
})
const emit = defineEmits(['update:modelValue'])

defineOptions({
  name: 'UserSelect',
  inheritAttrs: false,
})

const { data: queryResult } = useQuery({
  queryKey: ['users', 'options'],
  queryFn: () => UserService.userOptions(),
  staleTime: 1000 * 60,
})

const options = computed((): OptionItemModel[] => queryResult.value?.data ?? [])

const label = computed(() => useAttrs().label as string | 'Пользователь')

const selectValue = ref(props.modelValue)

watch(props, () => {
  selectValue.value = props.modelValue
})

watch(selectValue, () => {
  emit('update:modelValue', selectValue.value)
})

</script>

<template>
  <div>
    <SearchSelect
      v-if="options.length > 0"
      v-model="selectValue"
      :title="label"
      :options="options"
      label="label"
      :options-limit="10"
      open-direction="top"
      track-by="id"
      v-bind="{
      ...$attrs,
    }"
      clearable
    />
  </div>
</template>
