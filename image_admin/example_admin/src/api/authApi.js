import axios from '@/utils/request';

export function getAuthList(params) {
    return axios.post({
        url: '/auth/list',
        data: params
    }).then((res) => {
        return res
    })
}

export function editAuth(params) {
    return axios.post({
        url: '/auth/edit',
        data: params
    }).then((res) => {
        return res
    })
}

export function deleteAuth(params) {
    return axios.post({
        url: '/auth/delete',
        data: params
    }).then((res) => {
        return res
    })
}
