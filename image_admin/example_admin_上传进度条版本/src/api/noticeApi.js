import axios from '@/utils/request';

export function getNoticeList(params) {
    return axios.post({
        url: '/notice/list',
        data: params
    }).then((res) => {
        return res
    })
}

export function editNotice(params) {
    return axios.post({
        url: '/notice/edit',
        data: params
    }).then((res) => {
        return res
    })
}
