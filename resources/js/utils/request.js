import axiosService from './axioService'
import { MessageBox } from 'element-ui'

const request = {
    get(url, params) {
        return axiosService({
            url: url,
            method: 'GET',
            params: params,
        })
    },

    post(url, params) {
        return axiosService({
            url: url,
            method: 'POST',
            data: params,
        })
    },

    put(url, params) {
        return axiosService({
            url: url,
            method: 'PUT',
            data: params,
        })
    },

    delete(url, confirmMessage = 'Bạn có thực sự muốn xoá không?', params = {}) {
        return MessageBox.confirm(confirmMessage, 'Thông báo', {
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Huỷ',
            type: 'error'
        }).then(() => {
            return axiosService({
                url: url,
                method: 'DELETE',
                data: params,
            })
        })
    }
}

export default request
