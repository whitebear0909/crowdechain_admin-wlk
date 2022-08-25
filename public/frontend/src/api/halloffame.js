import request from '@/utils/request'

export function getHalloffames(query) {
  return request({
    url: '/halloffames',
    method: 'get',
    params: query
  })
}

export function createHalloffame(data) {
  return request({
    url: '/halloffame',
    method: 'post',
    data
  })
}
export function updateHalloffame(data) {
  return request({
    url: '/halloffame',
    method: 'put',
    data
  })
}

export function deleteHalloffame(id) {
  return request({
    url: '/halloffame/' + id,
    method: 'delete'
  })
}

export function getHalloffame(id) {
  return request({
    url: '/halloffame/' + id,
    method: 'get'
  })
}
