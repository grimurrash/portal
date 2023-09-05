<script setup lang="ts">
import UserBioPanel from '@/views/users/components/view/UserBioPanel.vue'
import UserTabSecurity from '@/views/users/components/view/UserTabSecurity.vue'
import UserTabAccount from '@/views/users/components/view/UserTabAccount.vue'

const route = useRoute()
const userTab = ref(null)

const tabs = [
  { icon: 'tabler-user-check', title: 'Подробно', key: 'account' },
  { icon: 'tabler-lock', title: 'Безопасность', key: 'security' },
]

userListStore.fetchUser(Number(route.params.id)).then(response => {
  userData.value = response.data
})
</script>

<template>
  <VRow>
    <VCol
      cols="12"
      md="5"
      lg="4"
    >
      <UserBioPanel :user-id="parseInt(route.params.id)"/>
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
