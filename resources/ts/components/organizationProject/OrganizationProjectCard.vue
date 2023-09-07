<script setup lang="ts">
import { Ref } from 'vue'
import {
  OrganizationProjectStatusColors,
  OrganizationProjectStatusNames
} from '@/types/enums/organization-project-status.enum'

defineOptions({
  name: 'OrganizationProjectCard',
  inheritAttrs: false,
})

interface Props {
  project: OrganizationProjectListItemModel
}

defineProps<Props>()

const isShowDetails: Ref<Map<any, any>> = ref(new Map())

const showDetail = (id: Number) => {
  if (isShowDetails.value.has(id)) {
    isShowDetails.value.set(id, !isShowDetails.value.get(id))
  } else {
    isShowDetails.value.set(id, true)
  }
}

</script>

<template>
  <VCard>
    <VCardItem>
      <VCardTitle>
        {{ project.name }}
      </VCardTitle>
    </VCardItem>

    <VCardText>
      <p class="mb-2">
        Номер: {{ project.number }}
      </p>
      <p class="mb-2">
        Время проведения: с {{ project.start_date }} по {{ project.end_date }}
      </p>
      <p class=" mb-2">
        Организатор: {{ project.organizer_user_name }}
      </p>
      <p class="mb-0">
        Статус:
        <VChip
          :color="OrganizationProjectStatusColors[project.status as keyof typeof OrganizationProjectStatusColors]"
          variant="elevated"
        >
          {{ OrganizationProjectStatusNames[project.status as keyof typeof OrganizationProjectStatusNames] }}
        </VChip>
      </p>
    </VCardText>
    <VCardActions>
      <slot name="actions"/>

      <VSpacer/>

      <VBtn
        icon
        size="small"
        @click="showDetail(project.id)"
      >
        <VIcon :icon="isShowDetails.get(project.id) ? 'tabler-chevron-up' : 'tabler-chevron-down'"/>
      </VBtn>
    </VCardActions>

    <VExpandTransition>
      <div v-show="isShowDetails.get(project.id)">
        <VDivider/>
        <VCardText>
          <p class="mb-2">
            Куратор: {{ project.curator_user_name }}
          </p>
          <p class="mb-2">
            Ответственный: {{ project.responsible_user_name }}
          </p>
          <p class="mb-2">Описание:</p>
          <p>{{ project.description }}</p>
        </VCardText>
      </div>
    </VExpandTransition>
  </VCard>

</template>
