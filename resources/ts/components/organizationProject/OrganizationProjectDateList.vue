<script setup lang="ts">
defineOptions({
  name: 'OrganizationProjectDateList',
  inheritAttrs: false,
})

interface Props {
  items:  OrganizationProjectDateItemModel[]
  isReadOnly: boolean
}

const props = defineProps<Props>()

const removeItem = (index: number) => {
  props.items.splice(index, 1)
}

</script>

<template>
  <VScaleTransition >
    <div v-if="items.length > 0 ">
      <p>Контрольные точки:</p>
      <transition-group name="scale" tag="div" >
        <template v-for="(date, index) in items" :key="`date_` + index">
          <VRow>
            <VCol :cols="4">
              <AppDateTimePicker
                v-if="!isReadOnly"
                v-model="date.date"
                :readonly="isReadOnly"
                placeholder="Дата и время"
              />
              <AppTextField
                v-else
                v-model="date.date"
                placeholder="Комментарий"
                readonly
              />
            </VCol>
            <VCol :cols="isReadOnly ? 8 : 7">
              <AppTextField
                v-model="date.name"
                placeholder="Комментарий"
                :readonly="isReadOnly"
              />
            </VCol>
            <VCol v-if="!isReadOnly" cols="1">
              <IconBtn @click="removeItem(index)">
                <VIcon
                  size="20"
                  icon="tabler-x"
                />
              </IconBtn>
            </VCol>
          </VRow>
        </template>
      </transition-group>
    </div>
  </VScaleTransition>
</template>
