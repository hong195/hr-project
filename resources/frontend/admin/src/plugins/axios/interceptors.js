import axios from 'axios'
import router from '@/router'

axios.interceptors.request.use(function (config) {
  const token = 'Bearer ' + localStorage.getItem('token')
  if (router.history.current.name !== 'login') {
    config.headers.Authorization = token
  }

  return config
})

axios.interceptors.response.use(function (response) {
  // Todo make before request handler
  return response
}, function (error) {
  // Todo make after response handler
  return Promise.reject(error)
})
