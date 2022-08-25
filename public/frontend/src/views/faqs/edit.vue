<template>
  <div class="createPost-container">
    <el-form ref="postForm" :model="postForm" :rules="rules" class="form-container">
      <div class="createPost-main-container">
        <el-row>
          <el-col :span="24">
            <el-form-item prop="question">
              <el-input v-model="postForm.question" name="question" :placeholder="$t('faq.question')" required />
            </el-form-item>
          </el-col>
          <el-col :span="24">
            <el-form-item prop="answer">
              <el-input v-model="postForm.answer" type="textarea" name="answer" :placeholder="$t('faq.answer')" required />
            </el-form-item>
          </el-col>
          <el-col :span="24">
            <el-form-item prop="product_filter">
              <label style="padding-bottom:5px">
                Dopo ogni id tour inserisci il ";".  Se è riferito a tutti i tour lascia il campo vuoto
              </label>
              <el-input v-model="postForm.product_filter" type="text" name="product_filter" placeholder="Filtro tour" />
            </el-form-item>
          </el-col>
        </el-row>
      </div>
      <div class="btns">
        <router-link :to="'/faqs/index'">
          <el-button type="primary" size="small" class="el-button el-button--danger el-button--medium" style="padding:10px;">{{ $t('table.cancel') }}</el-button>
        </router-link>
        <el-button v-loading="loading" class="el-button el-button--primary el-button--medium" @click="submitForm">
          {{ $t('user.update') }}
        </el-button>
      </div>
    </el-form>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { getFaqDetail, editFaq } from '@/api/faq'

export default {
  name: 'UpdateFaq',
  components: { },
  data() {
    const validateRequire = (rule, value, callback) => {
      if (value === '') {
        this.$message({
          message: rule.field.charAt(0).toUpperCase() + rule.field.slice(1) + ' is required',
          type: 'error'
        })
        callback(new Error(rule.field.charAt(0).toUpperCase() + rule.field.slice(1) + ' is required'))
      } else {
        callback()
      }
    }
    return {
      postForm: {},
      loading: false,
      faqId: null,
      rules: {
        question: [{ validator: validateRequire }],
        answer: [{ validator: validateRequire }]
      },
      tempRoute: {}
    }
  },
  computed: {
    ...mapGetters([
      'userid',
      'name',
      'usertype'
    ])
  },
  watch: {
    '$route'(to, from) {
      if (to.name === 'UpdateFaq') {
        this.getDetaail()
      }
    }
  },
  created() {
    this.getDetaail()
  },
  methods: {
    getDetaail() {
      this.faqId = this.$route.params && this.$route.params.id
      getFaqDetail(this.faqId).then(response => {
        this.postForm = response.data.data
      })
    },
    submitForm() {
      this.$refs.postForm.validate(valid => {
        if (valid) {
          this.loading = true
          editFaq(this.faqId, this.postForm).then(response => {
            this.$message({
              title: 'success',
              message: response.data.message,
              type: 'success',
              duration: 3000
            })
            this.loading = false
            this.$router.replace({ path: '/faqs/index' })
          }).catch(error => {
            this.loading = false
            console.log(error, 'error')
          })
        } else {
          return false
        }
      })
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
@import "~@/styles/mixin.scss";
.createPost-container {
  position: relative;
  .createPost-main-container {
    padding: 40px 45px 20px 50px;
    .material-input__component {
      margin-top: 10px;
    };
    .postInfo-container {
      position: relative;
      @include clearfix;
      margin-bottom: 10px;
      .postInfo-container-item {
        float: left;
      }
    }
  }
  .btns {
    text-align: center;
  }
  .word-counter {
    width: 40px;
    position: absolute;
    right: -10px;
    top: 0px;
  }
}
</style>
