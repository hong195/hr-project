export default function isAdmin ({ next, store }) {
  if (!store.state.user.isAdmin) {
    return next({
      name: 'login',
    })
  }
  return next()
}
