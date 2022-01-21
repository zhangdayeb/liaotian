import axios from '@/utils/request';

export function getCityList(params) {
    return axios.post({
        url: '/city/list',
        data: params
    }).then((res) => {
        return res
    })
}

export function getCityListAll(params) {
    return axios.post({
        url: '/city/listAll',
        data: params
    }).then((res) => {
        return res
    })
}

export function editCity(params) {
    return axios.post({
        url: '/city/edit',
        data: params
    }).then((res) => {
        return res
    })
}

export function deleteCity(params) {
    return axios.post({
        url: '/city/delete',
        data: params
    }).then((res) => {
        return res
    })
}
