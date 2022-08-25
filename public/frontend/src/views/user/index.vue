<template>
  <div class="logincontainer">
    <el-form ref="loginForm" :model="loginForm" :rules="loginRules" class="login-form" auto-complete="on" label-position="left">
      <div class="title-container">
        <h2 class="title">Welcome to complete Signup!!</h2>
      </div>
      <el-form-item prop="workstation">
        <el-input
          ref="workstation"
          v-model="loginForm.workstation"
          placeholder="Enter your workstation name"
          name="workstation"
          type="text"
          auto-complete="on"
        />
      </el-form-item>
      <el-form-item class="textcenter">
        <el-button :loading="loading" type="primary" style="width:150px;margin-bottom:30px;" @click.native.prevent="handleLogin">
          Submit
        </el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { addWorkstationName } from '@/api/faq'

export default {
  name: 'Signup',
  components: { },
  data() {
    return {
      loginForm: {
        workstation: ''
      },
      loginRules: {
        workstation: [{ required: true, message: 'Workstation name is required', trigger: 'blur' }]
      },
      loading: false,
      token: '',
      userid: ''
    }
  },
  computed: {
  },
  watch: {
    '$route': 'getData'
  },
  created() {
    this.getData()
  },
  methods: {
    getData() {
      this.token = this.$route.query.token
      this.userid = this.$route.query.id
    },
    handleLogin() {
      this.$refs.loginForm.validate(valid => {
        if (valid && this.token && this.userid) {
          this.loading = true
          var opts = {
            workstation_name: this.loginForm.workstation,
            token: this.token,
            userid: this.userid
          }
          addWorkstationName(opts).then(response => {
            this.$message({
              title: 'success',
              message: response.data.message,
              type: 'success',
              duration: 4000
            })
            this.loading = false
            this.$router.replace({ path: '/login' })
          }).catch(error => {
            this.loading = false
            this.$message({
              title: 'Error',
              message: error.data.message,
              type: 'error',
              duration: 4000
            })
          })
        } else {
          console.log('error submit!!')
          return false
        }
      })
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
  $bg:#283443;
  $light_gray:#eee;
  $cursor: #fff;
  .logincontainer {
    background-color: #283443;
    color: #fff;
    height: 100%;
    .title-container {
      text-align: center;
    }
    .login-form {
      width: 60%;
      margin: auto;
      padding: 50px;
    }
    .textcenter {
      text-align: center;
    }
  }
</style>
