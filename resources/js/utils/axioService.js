import axios from 'axios'
import { ElMessage } from 'element-plus';

const axioService = axios.create({
    baseURL: '',
    withCredentials: true,
    timeout: 5000,
})

axioService.interceptors.request.use(
    config => {
        return config
    },
    error => {
      return Promise.reject(error)
    }
)

axioService.interceptors.response.use(
    res => {
        if (res.data.status) {
            return res
        }
        ElMessage({
            showClose: true,
            message: res.data.message || 'Đã có lỗi sảy ra',
            type: 'error',
        })
    },
    err => {
        let errorMessage = ''

        if (err.response.status === 422) {
            errorMessage = err.response.data.message || 'Vui lòng kiểm tra lại thông tin đã nhập'
        }

        if (err.response.status === 500) {
            errorMessage = err.response.data.message || 'Sảy ra lỗi hệ thống'
        }

        if (err.response.status === 404) {
            errorMessage = err.response.data.message || 'Không tìm thấy trang'
        }

        if (err.response.status === 401) {
            errorMessage = err.response.data.message || 'Bạn không có quyền'
        }

        if (err.response.status === 400) {
            errorMessage = err.response.data.message || 'Thông tin nhập bị sai'
        }

        if (err.response.status === 403) {
            errorMessage = err.response.data.message || "403 Forbidden"
        }

        if (errorMessage) {
            ElMessage({
                showClose: true,
                message: errorMessage,
                type: 'error',
            })
        }

        return Promise.reject(err)
    }
)

export default axioService
