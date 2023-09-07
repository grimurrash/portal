<script setup lang="ts">
import { useQuery } from '@tanstack/vue-query'
import { UserService } from '@/services/management/user.service'

const route = useRoute()
const userTab = ref(null)

const tabs = [
  { icon: 'tabler-user-check', title: 'Подробно', key: 'account' },
  { icon: 'tabler-lock', title: 'Безопасность', key: 'security' },
]
const userId = route.params.id as string

const { data: showQueryResult } = useQuery({
  queryKey: ['users', 'show', userId],
  queryFn: () => UserService.show(userId)
})

const user = computed((): UserInfoResponse => showQueryResult.value?.data ?? {
  id: 0,
  name: '',
  email: '',
  roles: [],
  permissions: [],
})


</script>

<template>
  <VRow>
    <VCol
      cols="12"
      md="5"
      lg="4"
    >
      <UserBioPanel v-if="user" :user="user"/>
    </VCol>

    <VCol
      cols="12"
      md="7"
      lg="8"
    >
      <VTabs
        v-model="userTab"
        class="v-tabs-pill"
      >
        <VTab
          v-for="tab in tabs"
          :key="tab.icon"
          :disabled="tab.key === 'security'"
        >
          <VIcon
            :size="18"
            :icon="tab.icon"
            class="me-1"
          />
          <span>{{ tab.title }}</span>
        </VTab>
      </VTabs>

      <VWindow
        v-model="userTab"
        class="mt-6 disable-tab-transition"
        :touch="false"
      >
        <VWindowItem>
          <UserTabAccount />
        </VWindowItem>

        <VWindowItem>
          <UserTabSecurity />
        </VWindowItem>
      </VWindow>
    </VCol>
  </VRow>
</template>
