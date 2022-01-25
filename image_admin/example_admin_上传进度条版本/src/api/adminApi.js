import axios from '@/utils/request';

export function getAdminList(params) {
    return axios.post({
        url: '/admin/list',
        data: params
    }).then((res) => {
        return res
    })
}

export function editAdmin(params) {
    return axios.post({
        url: '/admin/edit',
        data: params
    }).then((res) => {
        return res
    })
}

export function deleteAdmin(params) {
    return axios.post({
        url: '/admin/delete',
        data: params
    }).then((res) => {
        return res
    })
}
