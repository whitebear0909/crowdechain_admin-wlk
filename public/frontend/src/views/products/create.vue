<template>
  <div class="createPost-container">
    <el-form
      ref="postForm"
      :model="postForm"
      :rules="rules"
      class="form-container"
    >
      <div class="createPost-main-container">
        <el-row :gutter="20">
          <el-col :span="2">
            <el-form-item>
              <el-checkbox
                v-model="postForm.is_tour"
                label="E' un tour?"
                type="checkbox"
                name="is_tour"
                required
                checked
              />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="4">
            <el-form-item label="ProductID">
              <el-input
                v-model="postForm.product_id"
                name="productid"
                :placeholder="$t('product.product_id')"
                required
              />
            </el-form-item>
          </el-col>
          <el-col :span="4">
            <el-form-item label="Product code">
              <el-input
                v-model="postForm.product_code"
                type="text"
                name="name"
                :placeholder="$t('product.productcode')"
                required
              />
            </el-form-item>
          </el-col>
          <el-col :span="4">
            <el-form-item label="Priority">
              <el-input
                v-model="postForm.priority"
                type="text"
                name="priority"
                placeholder="priority"
                required
              />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Name">
              <el-input
                v-model="postForm.name"
                type="text"
                name="name"
                :placeholder="$t('product.name')"
                required
              />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="24">
            <el-form-item label="Claim">
              <el-input
                v-model="postForm.claim"
                type="textarea"
                name="claim"
                placeholder="claim"
                required
              />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="3">
            <el-form-item label="Special Claim Type">
              <el-select v-model="postForm.special_claim_type">
                <el-option
                  v-for="item in special_claim_array"
                  :key="item.value"
                  :label="item.label"
                  :value="item.value"
                />
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="9">
            <el-form-item label="Special Claim">
              <el-input
                v-model="postForm.special_claim"
                type="textarea"
                name="special_claim"
                placeholder="special claim"
                required
              />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Why to book with us?">
              <el-input
                v-model="postForm.why_us"
                type="textarea"
                name="why_us"
                placeholder="Why to book with US"
                required
              />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="24">
            Description: <br><br>
            <el-form-item label="Description">
              <Tinymce
                v-model="postForm.description"
                :height="200"
                :language="en_US"
              />
              <!--
              <el-input v-model="postForm.description" type="textarea" name="description" :placeholder="$t('product.description')" required />
              -->
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="24">
            Private Tour Info: <br><br>
            <el-form-item label="Private Tour Info">
              <Tinymce
                v-model="postForm.private_tour"
                :height="200"
                :language="en_US"
              />
              <!--
              <el-input v-model="postForm.description" type="textarea" name="description" :placeholder="$t('product.description')" required />
              -->
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="6">
            <el-form-item label="Meta Title">
              <el-input
                v-model="postForm.meta_title"
                name="meta_title"
                :placeholder="$t('product.product_id')"
                required
              />
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item label="Url Freindly">
              <el-input
                v-model="postForm.url_personalizzato"
                type="text"
                name="url_personalizzato"
                :placeholder="$t('product.productcode')"
                required
              />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Meta Keywords">
              <el-input
                v-model="postForm.meta_keywords"
                type="text"
                name="meta_keywords"
                :placeholder="$t('product.name')"
                required
              />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item label="Meta Description">
              <el-input
                v-model="postForm.meta_description"
                type="textarea"
                name="meta_description"
                :placeholder="$t('product.description')"
                required
              />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Meta Keyphrases">
              <el-input
                v-model="postForm.meta_keyphrases"
                type="textarea"
                name="meta_keyphrases"
                :placeholder="$t('product.description')"
                required
              />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="24">
            <el-form-item>
              <label>Images</label>
              <div class="image-preview">
                <div
                  v-for="mg in postForm.fullImages"
                  :key="mg"
                  class="image-wrapper"
                >
                  <i
                    class="el-icon-delete image-action"
                    title="Remove"
                    @click="removeImage(mg)"
                  />
                  <img :src="mg" class="pimage">
                </div>
              </div>
              <el-upload
                :action="uploadFileUrl"
                list-type="picture-card"
                :auto-upload="true"
                :on-success="handleImageSuccess"
              >
                <i slot="default" class="el-icon-plus" />
                <div slot="file" slot-scope="{ file }">
                  <img
                    class="el-upload-list__item-thumbnail"
                    :src="file.url"
                    alt=""
                  >
                  <span class="el-upload-list__item-actions">
                    <span
                      class="el-upload-list__item-preview"
                      @click="handlePictureCardPreview(file)"
                    >
                      <i class="el-icon-zoom-in" />
                    </span>
                    <span
                      v-if="!disabled"
                      class="el-upload-list__item-delete"
                      @click="handleRemove(file)"
                    >
                      <i class="el-icon-delete" />
                    </span>
                  </span>
                </div>
              </el-upload>
              <el-dialog :visible.sync="dialogVisible">
                <img width="100%" :src="dialogImageUrl" alt="">
              </el-dialog>
            </el-form-item>
          </el-col>
        </el-row>
      </div>
      <div class="btns">
        <router-link :to="'/products/index'">
          <el-button
            type="primary"
            size="small"
            class="el-button el-button--danger el-button--medium"
            style="padding:10px;"
          >{{ $t("table.cancel") }}</el-button>
        </router-link>
        <el-button
          v-loading="loading"
          class="el-button el-button--primary el-button--medium"
          @click="submitForm"
        >
          {{ $t("user.add") }}
        </el-button>
      </div>
    </el-form>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { createProduct } from '@/api/product'
import Tinymce from '@/components/Tinymce'

const defaultForm = {
  product_id: '',
  product_code: '',
  name: '',
  description: '',
  meta_title: '',
  meta_description: '',
  meta_keyphrases: '',
  meta_keywords: '',
  url_personalizzato: '',
  images: []
}

export default {
  name: 'CreateProduct',
  components: { Tinymce },
  data() {
    const validateRequire = (rule, value, callback) => {
      if (value === '') {
        this.$message({
          message:
            rule.field.charAt(0).toUpperCase() +
            rule.field.slice(1) +
            ' is required',
          type: 'error'
        })
        callback(
          new Error(
            rule.field.charAt(0).toUpperCase() +
              rule.field.slice(1) +
              ' is required'
          )
        )
      } else {
        callback()
      }
    }
    return {
      special_claim_array: [
        { value: 0,
          label: 'Freccia'
        }, {
          value: 1,
          label: 'Freccia & W.A'
        }, {
          value: 2,
          label: 'Freccia & TripAdvisor'
        }
      ],
      postForm: Object.assign({}, defaultForm),
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
      uploadFileUrl: ''
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
    $route(to, from) {
      if (to.name === 'CreateProduct') {
        this.getProductDetail()
      }
    }
  },
  created() {
    this.getProductDetail()
  },
  methods: {
    getProductDetail() {
      this.uploadFileUrl = this.uploadfileurl
      this.defaultForm = {
        product_id: '',
        product_code: '',
        name: '',
        description: '',
        images: []
      }
    },
    submitForm() {
      this.$refs.postForm.validate(valid => {
        if (valid) {
          this.loading = true
          createProduct(this.postForm)
            .then(response => {
              this.$message({
                title: 'success',
                message: response.data.message,
                type: 'success',
                duration: 3000
              })
              this.loading = false
              this.$router.replace({ path: '/products/index' })
            })
            .catch(error => {
              this.loading = false
              console.log(error, 'error')
            })
        } else {
          console.log('error submit!!')
          return false
        }
      })
    },
    removeImage(img) {
      console.log('Going to remove image ', img)
    },
    handleRemove(file) {
      console.log(file, 'handle remove')
    },
    handlePictureCardPreview(file) {
      console.log('handle card picture', file)
      this.dialogImageUrl = file.url
      this.dialogVisible = true
    },
    handleDownload(file) {
      console.log(file, 'handle download')
    },
    handleImageSuccess(file) {
      console.log('After upload imae', file)
      this.postForm.images.push(file.data)
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
    }
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
