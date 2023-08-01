export default [
  {
    title: 'Dashboards',
    icon: { icon: 'tabler-smart-home' },
    children: [
      {
        title: 'Analytics',
        to: 'demo-dashboards-analytics',
      },
      {
        title: 'eCommerce',
        to: 'demo-dashboards-ecommerce',
      },
      {
        title: 'CRM',
        to: 'demo-dashboards-crm',
      },
    ],
    badgeContent: '3',
    badgeClass: 'bg-primary',
  },
  { heading: 'Apps & Pages' },
  {
    title: 'Email',
    icon: { icon: 'tabler-mail' },
    to: 'demo-apps-email',
  },
  {
    title: 'Chat',
    icon: { icon: 'tabler-message-circle' },
    to: 'demo-apps-chat',
  },
  {
    title: 'Calendar',
    icon: { icon: 'tabler-calendar' },
    to: 'demo-apps-calendar',
  },
  {
    title: 'Invoice',
    icon: { icon: 'tabler-file-dollar' },
    children: [
      { title: 'List', to: 'demo-apps-invoice-list' },
      { title: 'Preview', to: { name: 'demo-apps-invoice-preview-id', params: { id: '5036' } } },
      { title: 'Edit', to: { name: 'demo-apps-invoice-edit-id', params: { id: '5036' } } },
      { title: 'Add', to: 'demo-apps-invoice-add' },
    ],
  },
  {
    title: 'User',
    icon: { icon: 'tabler-users' },
    children: [
      { title: 'List', to: 'demo-apps-user-list' },
      { title: 'View', to: { name: 'demo-apps-user-view-id', params: { id: 21 } } },
    ],
  },
  {
    title: 'Roles & Permissions',
    icon: { icon: 'tabler-settings' },
    children: [
      { title: 'Roles', to: 'demo-apps-roles' },
      { title: 'Permissions', to: 'demo-apps-permissions' },
    ],
  },

  {
    title: 'Pages',
    icon: { icon: 'tabler-file' },
    children: [
      { title: 'Help Center', to: 'demo-pages-help-center' },
      { title: 'User Profile', to: { name: 'demo-pages-user-profile-tab', params: { tab: 'profile' } } },
      { title: 'Account Settings', to: { name: 'demo-pages-account-settings-tab', params: { tab: 'account' } } },

      { title: 'Pricing', to: 'demo-pages-pricing' },
      { title: 'FAQ', to: 'demo-pages-faq' },
      {
        title: 'Miscellaneous',
        children: [

          { title: 'Coming Soon', to: 'demo-pages-misc-coming-soon', target: '_blank' },
          { title: 'Under Maintenance', to: 'demo-pages-misc-under-maintenance', target: '_blank' },
          { title: 'Page Not Found - 404', to: 'demo-pages-misc-not-found', target: '_blank' },
          { title: 'Not Authorized - 401', to: 'demo-pages-misc-not-authorized', target: '_blank' },
          { title: 'Server Error - 500', to: 'demo-pages-misc-internal-server-error', target: '_blank' },
        ],
      },
    ],
  },
  {
    title: 'Authentication',
    icon: { icon: 'tabler-lock' },
    children: [
      {
        title: 'Login',
        children: [
          { title: 'Login v1', to: 'demo-pages-authentication-login-v1', target: '_blank' },
          { title: 'Login v2', to: 'demo-pages-authentication-login-v2', target: '_blank' },
        ],
      },
      {
        title: 'Register',
        children: [
          { title: 'Register v1', to: 'demo-pages-authentication-register-v1', target: '_blank' },
          { title: 'Register v2', to: 'demo-pages-authentication-register-v2', target: '_blank' },
          { title: 'Register Multi-Steps', to: 'demo-pages-authentication-register-multi-steps', target: '_blank' },
        ],
      },
      {
        title: 'Verify Email',
        children: [
          { title: 'Verify Email v1', to: 'demo-pages-authentication-verify-email-v1', target: '_blank' },
          { title: 'Verify Email v2', to: 'demo-pages-authentication-verify-email-v2', target: '_blank' },
        ],
      },
      {
        title: 'Forgot Password',
        children: [
          { title: 'Forgot Password v1', to: 'demo-pages-authentication-forgot-password-v1', target: '_blank' },
          { title: 'Forgot Password v2', to: 'demo-pages-authentication-forgot-password-v2', target: '_blank' },
        ],
      },
      {
        title: 'Reset Password',
        children: [
          { title: 'Reset Password v1', to: 'demo-pages-authentication-reset-password-v1', target: '_blank' },
          { title: 'Reset Password v2', to: 'demo-pages-authentication-reset-password-v2', target: '_blank' },
        ],
      },
      {
        title: 'Two Steps',
        children: [
          { title: 'Two Steps v1', to: 'demo-pages-authentication-two-steps-v1', target: '_blank' },
          { title: 'Two Steps v2', to: 'demo-pages-authentication-two-steps-v2', target: '_blank' },
        ],
      },
    ],
  },
  {
    title: 'Wizard Examples',
    icon: { icon: 'tabler-forms' },
    children: [
      { title: 'Checkout', to: { name: 'demo-wizard-examples-checkout' } },
      { title: 'Property Listing', to: { name: 'demo-wizard-examples-property-listing' } },
      { title: 'Create Deal', to: { name: 'demo-wizard-examples-create-deal' } },
    ],
  },
  {
    title: 'Dialog Examples',
    icon: { icon: 'tabler-square' },
    to: 'demo-pages-dialog-examples',
  },
  { heading: 'Demo ui' },
  { heading: 'UI Elements' },
  {
    title: 'Typography',
    icon: { icon: 'tabler-square-letter-t' },
    to: 'demo-pages-typography',
  },
  {
    title: 'Icons',
    icon: { icon: 'tabler-brand-tabler' },
    to: 'demo-pages-icons',
  },
  {
    title: 'Cards',
    icon: { icon: 'tabler-id' },
    children: [
      { title: 'Basic', to: 'demo-pages-cards-card-basic' },
      { title: 'Advance', to: 'demo-pages-cards-card-advance' },
      { title: 'Statistics', to: 'demo-pages-cards-card-statistics' },
      { title: 'Widgets', to: 'demo-pages-cards-card-widgets' },
      { title: 'Actions', to: 'demo-pages-cards-card-actions' },
    ],
  },
  {
    title: 'Components',
    icon: { icon: 'tabler-color-swatch' },
    children: [
      { title: 'Alert', to: 'demo-components-alert' },
      { title: 'Avatar', to: 'demo-components-avatar' },
      { title: 'Badge', to: 'demo-components-badge' },
      { title: 'Button', to: 'demo-components-button' },
      { title: 'Chip', to: 'demo-components-chip' },
      { title: 'Dialog', to: 'demo-components-dialog' },
      { title: 'Expansion Panel', to: 'demo-components-expansion-panel' },
      { title: 'List', to: 'demo-components-list' },
      { title: 'Menu', to: 'demo-components-menu' },
      { title: 'Pagination', to: 'demo-components-pagination' },
      { title: 'Progress Circular', to: 'demo-components-progress-circular' },
      { title: 'Progress Linear', to: 'demo-components-progress-linear' },
      { title: 'Snackbar', to: 'demo-components-snackbar' },
      { title: 'Tabs', to: 'demo-components-tabs' },
      { title: 'Timeline', to: 'demo-components-timeline' },
      { title: 'Tooltip', to: 'demo-components-tooltip' },
    ],
  },
  {
    title: 'Extensions',
    icon: { icon: 'mdi-cube-outline' },
    children: [
      { title: 'Tour', to: 'demo-extensions-tour' },
    ],
  },
  { heading: 'Forms & Tables' },
  {
    title: 'Form Elements',
    icon: { icon: 'tabler-toggle-left' },
    children: [
      { title: 'Autocomplete', to: 'demo-forms-autocomplete' },
      { title: 'Checkbox', to: 'demo-forms-checkbox' },
      { title: 'Combobox', to: 'demo-forms-combobox' },
      { title: 'Date Time Picker', to: 'demo-forms-date-time-picker' },
      { title: 'File Input', to: 'demo-forms-file-input' },
      { title: 'Radio', to: 'demo-forms-radio' },
      { title: 'Custom Input', to: 'demo-forms-custom-input' },
      { title: 'Range Slider', to: 'demo-forms-range-slider' },
      { title: 'Rating', to: 'demo-forms-rating' },
      { title: 'Select', to: 'demo-forms-select' },
      { title: 'Slider', to: 'demo-forms-slider' },
      { title: 'Switch', to: 'demo-forms-switch' },
      { title: 'Textarea', to: 'demo-forms-textarea' },
      { title: 'Textfield', to: 'demo-forms-textfield' },
    ],
  },
  {
    title: 'Form Layouts',
    icon: { icon: 'tabler-layout-navbar' },
    to: 'demo-forms-form-layouts',
  },
  {
    title: 'Form Validation',
    icon: { icon: 'tabler-checkbox' },
    to: 'demo-forms-form-validation',
  },
  {
    title: 'Tables',
    icon: { icon: 'tabler-table' },
    children: [
      { title: 'Simple Table', to: 'demo-tables-simple-table' },
      { title: 'Data Table', to: 'demo-tables-data-table' },
    ],
  },
  { heading: 'Charts' },
  {
    title: 'Charts',
    icon: { icon: 'tabler-chart-bar' },
    children: [
      { title: 'Apex Chart', to: 'demo-charts-apex-chart' },
      { title: 'Chartjs', to: 'demo-charts-chartjs' },
    ],
  },
  { heading: 'Others' },
  {
    title: 'Access Control',
    icon: { icon: 'tabler-command' },
    to: 'access-control',
    action: 'read',
    subject: 'AclDemo',
  },
  {
    title: 'Nav Levels',
    icon: { icon: 'tabler-menu-2' },
    children: [
      {
        title: 'Level 2.1',
        to: null,
      },
      {
        title: 'Level 2.2',
        children: [
          {
            title: 'Level 3.1',
            to: null,
          },
          {
            title: 'Level 3.2',
            to: null,
          },
        ],
      },
    ],
  },
  {
    title: 'Disabled Menu',
    to: null,
    icon: { icon: 'tabler-eye-off' },
    disable: true,
  },
  {
    title: 'Raise Support',
    href: 'https://pixinvent.ticksy.com/',
    icon: { icon: 'tabler-headphones' },
    target: '_blank',
  },
  {
    title: 'Documentation',
    href: 'https://demos.pixinvent.com/vuexy-vuejs-admin-template/documentation/guide/laravel-integration/folder-structure.html',
    icon: { icon: 'tabler-file-text' },
    target: '_blank',
  },
]
