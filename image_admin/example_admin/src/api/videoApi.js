import axios from '@/utils/request';

export function getVideoList(params) {
    return axios.post({
        url: '/video/list',
        data: params
    }).then((res) => {
        return res
    })
}

export function getVideoListAll(params) {
    return axios.post({
        url: '/video/listAll',
        data: params
    }).then((res) => {
        return res
    })
}

export function editVideo(params) {
    return axios.post({
        url: '/video/edit',
        data: params
    }).then((res) => {
        return res
    })
}

export function deleteVideo(params) {
    return axios.post({
        url: '/video/delete',
        data: params
    }).then((res) => {
        return res
    })
}
