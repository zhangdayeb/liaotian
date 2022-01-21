import axios from '@/utils/request';

export function getBeautifulList(params) {
    return axios.post({
        url: '/beautiful/list',
        data: params
    }).then((res) => {
        return res
    })
}

export function editBeautiful(params) {
    return axios.post({
        url: '/beautiful/edit',
        data: params
    }).then((res) => {
        return res
    })
}

export function deleteBeautiful(params) {
    return axios.post({
        url: '/beautiful/delete',
        data: params
    }).then((res) => {
        return res
    })
}
