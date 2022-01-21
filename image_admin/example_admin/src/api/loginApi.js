import axios from '@/utils/request';

export function loginApi(params) {
    return axios.post({
        url: '/login/login',
        data: params
    }).then((res) => {
        return res
    })
}

export function loadApi(params) {
    return axios.post({
        url: '/login/load',
        data: params
    }).then((res) => {
        return res
    })
}