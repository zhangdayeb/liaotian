import axios from '@/utils/request';

export function getCityConfigList(params) {
    return axios.post({
        url: '/city-config/list',
        data: params
    }).then((res) => {
        return res
    })
}

export function getCityConfigListAll(params) {
    return axios.post({
        url: '/city-config/listAll',
        data: params
    }).then((res) => {
        return res
    })
}
