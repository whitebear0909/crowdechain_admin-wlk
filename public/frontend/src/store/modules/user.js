import { loginByUsername, logout, getUserInfo } from '@/api/login'
import { getToken, setToken, removeToken } from '@/utils/auth'

const user = {
  state: {
    user: '',
    status: '',
    code: '',
    token: getToken(),
    name: '',
    avatar: '',
    introduction: '',
    roles: [],
    role: '',
    usertype: '',
    apiurl: '',
    uploadfileurl: '',
    storageurl: '',
    workstationid: '',
    workstationname: '',
    setting: {
      articlePlatform: []
    }
  },

  mutations: {
    SET_CODE: (state, code) => {
      state.code = code
    },
    SET_TOKEN: (state, token) => {
      state.token = token
    },
    SET_INTRODUCTION: (state, introduction) => {
      state.introduction = introduction
    },
    SET_SETTING: (state, setting) => {
      state.setting = setting
    },
    SET_STATUS: (state, status) => {
      state.status = status
    },
    SET_USERID: (state, userid) => {
      state.userid = userid
    },
    SET_NAME: (state, name) => {
      state.name = name
    },
    SET_AVATAR: (state, avatar) => {
      state.avatar = avatar
    },
    SET_ROLES: (state, roles) => {
      state.roles = roles
    },
    SET_ROLE: (state, role) => {
      state.role = role
    },
    SET_MODULE_ACCESS: (state, moduleaccess) => {
      state.moduleaccess = moduleaccess
    },
    SET_USERTYPE: (state, usertype) => {
      state.usertype = usertype
    },
    SET_WORKSTATIONID: (state, workstationid) => {
      state.workstationid = workstationid
    },
    SET_WORKSTATIONNAME: (state, workstationname) => {
      state.workstationname = workstationname
    },
    SET_APIURL: (state, apiurl) => {
      state.apiurl = apiurl
    },
    SET_UPLOADFILEURL: (state, url) => {
      state.uploadfileurl = url
    },
    SET_STORAGEURL: (state, storageurl) => {
      state.storageurl = storageurl
    }
  },

  actions: {
    // 用户名登录
    LoginByUsername({ commit }, userInfo) {
      const username = userInfo.username.trim()
      return new Promise((resolve, reject) => {
        loginByUsername(username, userInfo.password).then(response => {
          const data = response.data
          commit('SET_TOKEN', data.token)
          setToken(response.data.token)
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },

    // Get user information
    GetUserInfo({ commit, state }) {
      return new Promise((resolve, reject) => {
        getUserInfo(state.token).then(response => {
          // Since mockjs does not support custom status codes, it can only be hacked like this
          if (!response.data) {
            reject('Verification failed, please login again.')
          }
          const data = response.data.data

          if (data.roles && data.roles.length > 0) { // Verify that the returned roles are a non-null array
            commit('SET_ROLES', data.roles)
          } else {
            reject('getInfo: roles must be a non-null array!')
          }
          commit('SET_USERID', data.id)
          commit('SET_NAME', data.name)
          commit('SET_AVATAR', data.avatar)
          commit('SET_INTRODUCTION', data.introduction)
          commit('SET_USERTYPE', data.usertype)
          commit('SET_APIURL', data.api_url)
          commit('SET_UPLOADFILEURL', data.upload_file_url)
          commit('SET_STORAGEURL', data.storage_url)
          resolve(response.data)
        }).catch(error => {
          reject(error)
        })
      })
    },

    LogOut({ commit, state }) {
      return new Promise((resolve, reject) => {
        logout(state.token).then(() => {
          commit('SET_TOKEN', '')
          commit('SET_ROLES', [])
          removeToken()
          resolve()
        }).catch(error => {
          reject(error)
        })
      })
    },

    FedLogOut({ commit }) {
      return new Promise(resolve => {
        commit('SET_TOKEN', '')
        removeToken()
        resolve()
      })
    },

    ChangeRoles({ commit, dispatch }, role) {
      return new Promise(resolve => {
        commit('SET_TOKEN', role)
        setToken(role)
        getUserInfo(role).then(response => {
          const data = response.data
          commit('SET_ROLES', data.roles)
          commit('SET_NAME', data.name)
          commit('SET_AVATAR', data.avatar)
          commit('SET_INTRODUCTION', data.introduction)
          dispatch('GenerateRoutes', data) // 动态修改权限后 重绘侧边菜单
          resolve()
        })
      })
    }
  }
}

export default user
