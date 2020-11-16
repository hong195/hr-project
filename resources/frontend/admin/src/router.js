import Vue from 'vue'
import Router from 'vue-router'
import store from './store'
import auth from './middleware/auth'
// import hasPermission from './middleware/hasPermission'
import middlewarePipeline from './middleware/middlewarePipeline'
import isAdmin from './middleware/isAdmin'
import isSubscriber from './middleware/isSubscriber'
import isEditor from './middleware/isEditor'
Vue.use(Router)
const router = new Router({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/pages',
      component: () => import('@/views/pages/Index'),
      children: [
        {
          name: 'login',
          path: 'login',
          component: () => import('@/views/pages/Login'),
        },
        {
          name: 'Register',
          path: 'register',
          component: () => import('@/views/pages/Register'),
        },
      ],
    },
    {
      path: '/',
      component: () => import('@/views/dashboard/Index'),
      name: 'App',
      meta: {
        middleware: [
          auth,
        ],
      },
      children: [
        {
          name: 'home',
          path: 'home',
          component: () => import('@/views/dashboard/Dashboard'),
          meta: {
            middleware: [
              auth,
            ],
          },
        },
        {
          name: 'pharmacy',
          path: 'pharmacy',
          component: () => import('@/views/dashboard/pages/pharmacies/Index'),
          meta: {
            middleware: [
              isEditor,
            ],
          },
        },
        {
          name: 'create-pharmacy',
          path: 'create-pharmacy',
          component: () => import('@/views/dashboard/pages/pharmacies/CreateUpdate'),
          meta: {
            middleware: [
              isEditor,
            ],
          },
        },
        {
          name: 'update-pharmacy',
          path: 'update-pharmacy/:id',
          component: () => import('@/views/dashboard/pages/pharmacies/CreateUpdate'),
          meta: {
            middleware: [
              isEditor,
            ],
          },
        },
        {
          name: 'staff',
          path: 'staff',
          component: () => import('@/views/dashboard/pages/staffs/Index'),
          meta: {
            middleware: [
              isEditor,
            ],
          },
        },
        {
          name: 'create-staff',
          path: 'create-staff',
          component: () => import('@/views/dashboard/pages/staffs/CreateUpdate'),
          meta: {
            middleware: [
              isEditor,
            ],
          },
        },
        {
          name: 'update-staff',
          path: 'update-staff/:id',
          component: () => import('@/views/dashboard/pages/staffs/CreateUpdate'),
          meta: {
            middleware: [
              isEditor,
            ],
          },
        },
        {
          name: 'ratings-staff',
          path: 'ratings-staff',
          component: () => import('@/views/dashboard/pages/ratings/Staff'),
          meta: {
            middleware: [
              auth,
            ],
          },
        },
        {
          name: 'checks',
          path: 'checks',
          component: () => import('@/views/dashboard/pages/checks/Index'),
          meta: {
            middleware: [
              isEditor,
            ],
          },
        },
        {
          name: 'create-checks',
          path: 'create-checks',
          component: () => import('@/views/dashboard/pages/checks/Create'),
          meta: {
            middleware: [
              isEditor,
            ],
          },
        },
        {
          name: 'update-checks',
          path: 'update-checks/:id',
          component: () => import('@/views/dashboard/pages/checks/Create'),
          meta: {
            middleware: [
              isEditor,
            ],
          },
        },
        {
          name: 'attributes',
          path: 'attributes',
          component: () => import('@/views/dashboard/pages/attributes/Index'),
          meta: {
            middleware: [
              isAdmin,
            ],
          },
        },
        {
          name: 'create-attributes',
          path: 'create-attributes',
          component: () => import('@/views/dashboard/pages/attributes/CreateUpdate'),
          meta: {
            middleware: [
              isAdmin,
            ],
          },
        },
        {
          name: 'update-attributes',
          path: 'update-attributes/:id',
          component: () => import('@/views/dashboard/pages/attributes/CreateUpdate'),
          meta: {
            middleware: [
              isAdmin,
            ],
          },
        },
        {
          name: 'create-attribute-options',
          path: 'create-attribute-options',
          component: () => import('@/views/dashboard/pages/options/Create'),
          meta: {
            middleware: [
              isAdmin,
            ],
          },
        },

      ],
    },
    {
      path: '*',
      component: () => import('@/views/pages/Index'),
      children: [
        {
          name: '404 Error',
          path: '',
          component: () => import('@/views/pages/Error'),
        },
      ],
    },
  ],
})

router.beforeEach((to, from, next) => {
  if (!to.meta.middleware) {
    return next()
  }
  const middleware = to.meta.middleware
  const context = {
    to,
    from,
    next,
    store,
  }
  return middleware[0]({
    ...context,
    next: middlewarePipeline(context, middleware, 1),
  })
})
export default router
