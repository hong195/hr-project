import axios from 'axios'

axios.interceptors.response.use(function (response) {
  // Todo make before request handler
  return response
}, function (error) {
  // Todo make after response handler
  return Promise.reject(error)
})
