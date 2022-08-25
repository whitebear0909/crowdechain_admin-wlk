<template>
  <div class="createPost-container">
    <el-form ref="halloffame" :model="halloffame" :rules="rules" class="form-container">
      <div class="createPost-main-container">
        <el-row :gutter="20">
          <el-col :span="24">
            <el-form-item label="Title">
              <el-input v-model="halloffame.title" type="text" name="title" :placeholder="$t('product.name')" required />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Author">
              <el-input v-model="halloffame.author" name="author" placeholder="Nickname" required />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Alt">
              <el-input v-model="halloffame.property_alt" type="property_alt" name="name" placeholder="Alt" required />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item label="Home order number">
              <label style="padding-bottom:5px">
                Please: Insert a number > 0 to display it in home page
              </label>
              <el-input v-model="halloffame.home_order" type="text" name="home_order" placeholder="home order" required />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Instagram url">
              <el-input v-model="halloffame.instagram_url" type="text" name="instagram_url" placeholder="Url" required />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="24">
            <el-form-item label="Product Filter">
              <label style="padding-bottom:5px">
                Plese: After id tour insert  ";".  If it is referred to all tours leave the field empty
              </label>
              <el-input v-model="halloffame.product_filter" type="text" name="product_filter" placeholder="Product Filter" />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="6">
            <el-form-item>
              <el-upload class="avatar-uploader" :action="uploadFileUrl" :on-success="handleAvatarSuccess" :on-remove="handleRemove">
                <img v-if="imageUrl" :src="imageUrl" class="avatar" width="100px">
                <i v-else class="el-icon-plus upload-icon" style="width:100px; height:100px;" />
              </el-upload>
            </el-form-item>
          </el-col>
        </el-row>
      </div>
      <div class="btns">
        <router-link :to="'/halloffame/index'">
          <el-button type="primary" size="small" class="el-button el-button--danger el-button--medium" style="padding:10px;">{{ $t('table.cancel') }}</el-button>
        </router-link>
        <el-button v-loading="loading" class="el-button el-button--primary el-button--medium" @click="submitForm">
          {{ halloffame.halloffame_id > 0? $t('user.update'):$t('user.add') }}
        </el-button>
      </div>
    </el-form>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { createHalloffame, updateHalloffame, getHalloffame } from '@/api/halloffame'

export default {
  name: 'CreateHalloffame',
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
      halloffame: {
        title: '',
        property_alt: '',
        description: '',
        img: '',
        author: '',
        instagram_url: '',
        halloffame_id: 0,
        fullimgurl: ''
      },
      roles: null,
      loading: false,
      rules: {
        product_id: [{ validator: validateRequire }],
        product_code: [{ validator: validateRequire }],
        name: [{ validator: validateRequire }],
        description: [{ validator: validateRequire }]
      },
      tempRoute: {},
      dialogImageUrl: '',
      dialogVisible: false,
      disabled: false,
      uploadFileUrl: '',
      imageUrl: ''
    }
  },
  computed: {
    ...mapGetters([
      'userid',
      'name',
      'avatar',
      'usertype',
      'role',
      'uploadfileurl',
      'token'
    ])
  },
  watch: {
    '$route'(to, from) {
      if (to.name === 'CreateProduct') {
        this.getProductDetail()
      }
    }
  },
  created() {
    this.uploadFileUrl = this.uploadfileurl
    if (this.$route.params && this.$route.params.id > 0) {
      this.getDetail(this.$route.params.id)
    }
  },
  methods: {
    getDetail(id) {
      getHalloffame(id).then(response => {
        this.halloffame = response.data.data
        this.halloffame.halloffame_id = id
        this.imageUrl = this.halloffame.fullimgurl
      })
    },
    submitForm() {
      /* this.$refs.postForm.validate(valid => {
       // if (valid) {*/
      this.loading = true
      console.log(' this.postForm ', this.halloffame)
      if (this.halloffame.halloffame_id > 0) {
        updateHalloffame(this.halloffame).then(response => {
          this.$message({
            title: 'success',
            message: 'Updated',
            type: 'success',
            duration: 3000
          })
          this.loading = false
          this.$router.replace({ path: '/halloffames/index' })
        }).catch(error => {
          this.loading = false
          console.log(error, 'error')
        })
      } else {
        createHalloffame(this.halloffame).then(response => {
          this.$message({
            title: 'success',
            message: 'Created',
            type: 'success',
            duration: 3000
          })
          this.loading = false
          this.$router.replace({ path: '/halloffames/index' })
        }).catch(error => {
          this.loading = false
          console.log(error, 'error')
        })
      }
      /*
        } else {
          console.log('error submit!!')
          return false
        }
      })*/
    },
    handleAvatarSuccess(res, file) {
      this.halloffame.img = res.data
      this.imageUrl = URL.createObjectURL(file.raw)
    },
    beforeAvatarUpload(file) {
      // //this.imageUrl = file.url
    },
    handleRemove() {
      this.halloffame.img = ''
      this.imageUrl = ''
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
@import "~@/styles/mixin.scss";
.createPost-container {
  position: relative;
  .pullright {
    float: right;
  }
  .remove {
    color: red;
    border: 1px solid red;
    border-radius: 50%;
    position: relative;
    top: -5px;
    cursor: pointer;
  }
  .fullitinerarylist {
    border: 1px solid #e0dcdc;
    padding: 10px;
    margin-top: 10px;
    margin-bottom: 10px;
    i {
      float: right;
    }
  }
  .fullitinerary {
    border: 1px solid #ededed;
    padding: 10px;
  }
  .upload-icon {
    width: 100px;
    height: 100px;
    vertical-align: middle;
    line-height: 88px;
    margin-bottom: 10px;
    border: 1px solid #d2cfcf;
  }
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
  .image-preview {
    width: 100%;
    .image-wrapper {
      width: 200px;
      height: 180px;
      float: left;
      margin-right: 10px;
      border: 1px solid #eee;
      .pimage {
        width: 100%;
      }
      .image-action {
        float: right;
        padding: 2px;
        cursor: pointer;
      }
    }
  }
}
</style>
