export default function isAdmin ({ next, store }) {
  if (!store.getters.isAdmin) {
    return next({
      name: 'login',
    })
  }
  return next()
}
