import axios from '@/utils/request';

export function getVideoTypeList(params) {
    return axios.post({
        url: '/video-type/list',
        data: params
    }).then((res) => {
        return res
    })
}

export function getVideoTypeListAll(params) {
    return axios.post({
        url: '/video-type/listAll',
        data: params
    }).then((res) => {
        return res
    })
}

export function editVideoType(params) {
    return axios.post({
        url: '/video-type/edit',
        data: params
    }).then((res) => {
        return res
    })
}

export function deleteVideoType(params) {
    return axios.post({
        url: '/video-type/delete',
        data: params
    }).then((res) => {
        return res
    })
}
