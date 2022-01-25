import axios from '@/utils/request';

export function getRoleList(params) {
    return axios.post({
        url: '/role/list',
        data: params
    }).then((res) => {
        return res
    })
}

export function getRoleListAll(params) {
    return axios.post({
        url: '/role/listAll',
        data: params
    }).then((res) => {
        return res
    })
}

export function editRole(params) {
    return axios.post({
        url: '/role/edit',
        data: params
    }).then((res) => {
        return res
    })
}

export function deleteRole(params) {
    return axios.post({
        url: '/role/delete',
        data: params
    }).then((res) => {
        return res
    })
}
