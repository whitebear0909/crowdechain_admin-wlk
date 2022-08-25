import request from '@/utils/request'

export function getProductList(query) {
  return request({
    url: '/product',
    method: 'get',
    params: query
  })
}

export function editProduct(id, data) {
  return request({
    url: '/product/' + id,
    method: 'put',
    data
  })
}

export function createProduct(data) {
  return request({
    url: '/product',
    method: 'post',
    data
  })
}

export function deleteProduct(id) {
  return request({
    url: '/product/' + id,
    method: 'delete'
  })
}

export function getProductDetail(id) {
  return request({
    url: '/product/' + id,
    method: 'get'
  })
}
