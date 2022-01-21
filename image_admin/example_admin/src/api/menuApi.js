import axios from '@/utils/request';

export function getMenuListAll(params) {
  return axios.post({
    url: '/menu/listAll',
      data: params
  }).then((res) => {
    return res
  })
}

export function getMenuList(params) {
    return axios.post({
        url: '/menu/list',
        data: params
    }).then((res) => {
        return res
    })
}

export function editMenu(params) {
    return axios.post({
        url: '/menu/edit',
        data: params
    }).then((res) => {
        return res
    })
}

export function deleteMenu(params) {
    return axios.post({
        url: '/menu/delete',
        data: params
    }).then((res) => {
        return res
    })
}

export function getMenuParentList(params) {
    return axios.post({
        url: '/menu/parentList',
        data: params
    }).then((res) => {
        return res
    })
}