import axios from '@/utils/request';

export function getRouteList(params) {
    return axios.post({
        url: '/route/list',
        data: params
    }).then((res) => {
        return res
    })
}

export function editRoute(params) {
    return axios.post({
        url: '/route/edit',
        data: params
    }).then((res) => {
        return res
    })
}

export function deleteRoute(params) {
    return axios.post({
        url: '/route/delete',
        data: params
    }).then((res) => {
        return res
    })
}
