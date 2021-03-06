<template>
  <v-navigation-drawer
    id="core-navigation-drawer"
    v-model="drawer"
    :dark="barColor !== 'rgba(255, 255, 255, 1), rgba(255, 255, 255, 0.7)'"
    :expand-on-hover="expandOnHover"
    :right="$vuetify.rtl"
    :src="barImage"
    mobile-breakpoint="960"
    app
    width="260"
    v-bind="$attrs"
  >
    <template v-slot:img="props">
      <v-img :gradient="`to bottom, ${barColor}`" v-bind="props" />
    </template>

    <v-list-item two-line>
      <v-list-item-content>
        <v-list-item-title class="text-uppercase font-weight-regular display-2">
          <span class="logo-mini">Hr Project</span>
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>

    <v-divider class="mb-1" />

    <v-list dense nav>
      <base-item-group :item="profile" />
    </v-list>

    <v-divider class="mb-2" />

    <v-list expand nav>
      <template v-for="(item, i) in computedItems">
        <base-item-group v-if="item.children" :key="`group-${i}`" :item="item">
        </base-item-group>

        <base-item v-else :key="`item-${i}`" :item="item" />
      </template>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
  // Utilities
  import { mapState, mapGetters, mapActions } from 'vuex'

  export default {
    name: 'DashboardCoreDrawer',

    props: {
      expandOnHover: {
        type: Boolean,
        default: false,
      },
    },

    data: () => ({
      items: [
        {
          icon: 'mdi-view-dashboard',
          title: 'mainPage',
          to: '/home',
        },
        {
          to: '/pharmacy',
          icon: 'mdi-image',
          title: 'pharmacy',
        },
        {
          to: '/staff',
          icon: 'mdi-view-comfy',
          title: 'staff',
        },
        {
          to: '/ratings-staff',
          icon: 'mdi-view-comfy',
          title: 'ratings',
        },
      ],
      itemsAdmin: [
        {
          icon: 'mdi-view-dashboard',
          title: 'mainPage',
          to: '/home',
        },
        {
          icon: 'mdi-animation',
          title: 'checks',
          group: '',
          children: [
            {
              to: 'checks',
              title: 'checks',
            },
            {
              to: 'checks-create',
              title: 'checks-create',
            },
          ],
        },
        {
          icon: 'mdi-account-multiple',
          title: 'attributes',
          group: '',
          children: [
            {
              to: 'attributes',
              title: 'attributes',
            },
            {
              to: 'create-attributes',
              title: 'create-attributes',
            },
            {
              to: 'create-attribute-options',
              title: 'create-attribute-options',
            },
          ],
        },
        {
          icon: 'mdi-account-multiple',
          title: 'pharmacy',
          group: '',
          children: [
            {
              to: 'pharmacy',
              avatar: 'mdi-view-comfy',
              title: 'pharmacy',
            },
            {
              to: 'create-pharmacy',
              avatar: 'mdi-clipboard-outline',
              title: 'createPharmacy',
            },
          ],
        },
        {
          icon: 'mdi-account-multiple',
          title: 'staff',
          group: '',
          children: [
            {
              to: 'staff',
              avatar: 'mdi-view-comfy',
              title: 'staff',
            },
            {
              to: 'create-staff',
              avatar: 'mdi-clipboard-outline',
              title: 'createStaff',
            },
            {
              to: 'ratings-staff',
              icon: 'mdi-view-comfy',
              title: 'ratings',
            },
          ],
        },
      ],
    }),

    computed: {
      ...mapState(['barColor', 'barImage']),
      ...mapActions('user', ['logOut']),
      ...mapGetters({ user: 'user/currentUser' }),
      drawer: {
        get () {
          return this.$store.state.drawer
        },
        set (val) {
          this.$store.commit('SET_DRAWER', val)
        },
      },
      computedItems () {
        return this.$store.state.user.isAdmin
          ? this.itemsAdmin.map(this.mapItem)
          : this.items.map(this.mapItem)
      },
      profile () {
        if (!this.user) {
          return {}
        }
        return {
          avatar: true,
          group: '',
          title: this.user.first_name + ' ' + this.user.last_name,
          children: [
            {
              to: `create-staff?edit=true&id=${this.user.id}`,
              title: this.$t('edit_profile'),
            },
            {
              to: undefined,
              name: 'logout',
              title: 'Выйти',
              callback: () => {
                try {
                  // eslint-disable-next-line vue/no-side-effects-in-computed-properties
                  this.$router.push({ name: 'login' })
                  this.logOut()
                } catch (e) {
                  console.log(e)
                }
              },
            },
          ],
        }
      },
    },

    watch: {
      '$vuetify.breakpoint.smAndDown' (val) {
        this.$emit('update:expandOnHover', !val)
      },
    },

    methods: {
      mapItem (item) {
        return {
          ...item,
          children: item.children ? item.children.map(this.mapItem) : undefined,
          title: this.$t(item.title),
        }
      },
    },
  }
</script>

<style lang="sass">
@import '~vuetify/src/styles/tools/_rtl.sass'

#core-navigation-drawer
  &.v-navigation-drawer--mini-variant
    .v-list-item
      justify-content: flex-start !important

    .v-list-group--sub-group
      display: block !important

  .v-list-group__header.v-list-item--active:before
    opacity: .24

  .v-list-item
    &__icon--text,
    &__icon:first-child
      justify-content: center
      text-align: center
      width: 20px

      +ltr()
      margin-right: 24px
      margin-left: 12px !important

      +rtl()
      margin-left: 24px
      margin-right: 12px !important

  .v-list--dense
    .v-list-item
      &__icon--text,
      &__icon:first-child
        margin-top: 10px

  .v-list-group--sub-group
    .v-list-item
      +ltr()
      padding-left: 8px

      +rtl()
      padding-right: 8px

    .v-list-group__header
      +ltr()
      padding-right: 0

      +rtl()
      padding-right: 0

      .v-list-item__icon--text
        margin-top: 19px
        order: 0

      .v-list-group__header__prepend-icon
        order: 2

        +ltr()
        margin-right: 8px

        +rtl()
        margin-left: 8px
</style>
