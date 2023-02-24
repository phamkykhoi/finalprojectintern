import axiosService from './axioService'

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

    delete(url, params = {}) {
        return axiosService({
            url: url,
            method: 'DELETE',
            data: params,
        })
    }
}

export default request
