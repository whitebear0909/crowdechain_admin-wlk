import request from '@/utils/request'

export function getFaqList(query) {
  return request({
    url: '/web/faqs',
    method: 'get',
    params: query
  })
}

export function getGroupRoles() {
  return request({
    url: '/users/role',
    method: 'get'
  })
}

export function editFaq(id, data) {
  return request({
    url: '/faqs/' + id,
    method: 'put',
    data
  })
}

export function createFaq(data) {
  return request({
    url: '/faqs',
    method: 'post',
    data
  })
}

export function verifyEmail(data) {
  return request({
    url: '/user/verify/email',
    method: 'post',
    data
  })
}

export function addWorkstationName(data) {
  return request({
    url: '/user/signup/complete',
    method: 'post',
    data
  })
}

export function deleteFaq(id) {
  return request({
    url: '/faqs/' + id,
    method: 'delete'
  })
}

export function getFaqDetail(id) {
  return request({
    url: '/faqs/' + id,
    method: 'get'
  })
}

export function addAbout(data) {
  return request({
    url: '/aboutus',
    method: 'post',
    data
  })
}

export function getAboutUs() {
  return request({
    url: '/aboutus',
    method: 'get'
  })
}

export function editAbout(id, data) {
  return request({
    url: '/aboutus/' + id,
    method: 'put',
    data
  })
}
