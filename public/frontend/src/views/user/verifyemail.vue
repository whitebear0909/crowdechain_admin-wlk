<template>
  <div class="logincontainer">
    Loading...
  </div>
</template>

<script>
import { verifyEmail } from '@/api/faq'

export default {
  name: 'VerifyAccountEmail',
  components: { },
  data() {
    return {
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
      if (this.token && this.userid) {
        this.loading = true
        var opts = {
          token: this.token,
          userid: this.userid
        }
        verifyEmail(opts).then(response => {
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
          this.$router.replace({ path: '/login' })
        })
      } else {
        this.$router.replace({ path: '/login' })
      }
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
    text-align: center;
    padding: 20px;
  }
</style>
