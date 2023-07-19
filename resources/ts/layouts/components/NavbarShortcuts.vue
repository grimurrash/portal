<script setup lang="ts">
const shortcuts = [
  {
    icon: 'tabler-calendar',
    title: 'Calendar',
    subtitle: 'Appointments',
    to: { name: 'demo-apps-calendar' },
  },
  {
    icon: 'tabler-file',
    title: 'Invoice App',
    subtitle: 'Manage Accounts',
    to: { name: 'demo-apps-invoice-list' },
  },
  {
    icon: 'tabler-user',
    title: 'Users',
    subtitle: 'Manage Users',
    to: { name: 'demo-apps-user-list' },
  },
  {
    icon: 'tabler-layout',
    title: 'Dashboard',
    subtitle: 'Dashboard Analytics',
    to: { name: 'demo-dashboards-analytics' },
  },
  {
    icon: 'tabler-settings',
    title: 'Settings',
    subtitle: 'Account Settings',
    to: { name: 'demo-pages-account-settings-tab', params: { tab: 'account' } },
  },
  {
    icon: 'tabler-help',
    title: 'Help Center',
    subtitle: 'FAQs & Articles',
    to: { name: 'demo-pages-help-center' },
  },
]
</script>

<template>
  <Shortcuts :shortcuts="shortcuts" />
</template>
