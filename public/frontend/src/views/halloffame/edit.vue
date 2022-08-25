<template>
  <div class="createPost-container">
    <el-form ref="postForm" :model="postForm" :rules="rules" class="form-container">
      <div class="createPost-main-container">
        <el-row :gutter="20">
          <el-col :span="6">
            <el-form-item label="ProductID">
              <el-input v-model="postForm.product_id" name="productid" :placeholder="$t('product.product_id')" required />
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item label="Product code">
              <el-input v-model="postForm.product_code" type="text" name="name" :placeholder="$t('product.productcode')" required />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Name">
              <el-input v-model="postForm.name" type="text" name="name" :placeholder="$t('product.name')" required />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="24">
            <el-form-item label="Description">
              <el-input v-model="postForm.description" type="textarea" name="description" :placeholder="$t('product.description')" required />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row>
          <el-col :span="24">
            <el-form-item label="Product filter">
              <label style="padding-bottom:5px">
                Dopo ogni id tour inserisci il ";".  Se è riferito a tutti i tour lascia il campo vuoto
              </label>
              <el-input v-model="postForm.product_filter" type="text" name="description" placeholder="Product filter" />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="6">
            <el-form-item label="Meta Title">
              <el-input v-model="postForm.meta_title" name="meta_title" required />
            </el-form-item>
          </el-col>
          <el-col :span="6">
            <el-form-item label="Url Freindly">
              <el-input v-model="postForm.url_personalizzato" type="text" name="url_personalizzato" required />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Meta Keywords">
              <el-input v-model="postForm.meta_keywords" type="text" name="meta_keywords" required />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="12">
            <el-form-item label="Meta Description">
              <el-input v-model="postForm.meta_description" type="textarea" name="meta_description" required />
            </el-form-item>
          </el-col>
          <el-col :span="12">
            <el-form-item label="Meta Keyphrases">
              <el-input v-model="postForm.meta_keyphrases" type="textarea" name="meta_keyphrases" required />
            </el-form-item>
          </el-col>
        </el-row>
        <el-row class="fullitinerary">
          <el-row :gutter="20">
            <el-col :span="20"><el-form-item label="Highlights" /></el-col>
            <el-col :span="4"><el-button v-if="!showHighlight" class="pullright" type="primary" @click="showHighlight=true">Add</el-button></el-col>
          </el-row>

          <div v-for="(t, i) in postForm.highlights" :key="t" :span="24" class="fullitinerarylist">
            <i slot="default" class="el-icon-close remove" title="Remove" @click="removeHightlight(i)" />
            <p>{{ t }}</p>
          </div>
          <el-row :gutter="20">
            <el-col v-if="showHighlight" :span="20"><el-input v-model="highlight" type="text" name="Enter text" :placeholder="$t('product.highlighttext')" required /></el-col>
            <el-col v-if="showHighlight" :span="4"><el-button type="primary" @click="addHighlight(highlight)">Done</el-button></el-col>
          </el-row>
        </el-row>
        <el-row class="fullitinerary">
          <el-row :gutter="20">
            <el-col :span="20"><el-form-item label="Full Itinerary" /></el-col>
            <el-col :span="4"><el-button v-if="!showFullItinerary" class="pullright" type="primary" @click="showFullItinerary=true">Add</el-button></el-col>
          </el-row>
          <div v-for="(t, j) in postForm.fullitinerary" :key="j" :span="24" class="fullitinerarylist">
            <label>{{ t.title }} </label>
            <span v-if="t.is_special">  - {{ $t('product.specialDescriscption') }} </span>
            <i slot="default" class="el-icon-close remove" title="Remove" @click="removeFullItinerary(j)" />
            <p>{{ t.description }}</p>

          </div>
          <div>
            <el-form-item v-if="showFullItinerary">
              <el-input v-model="fullItineraryTitle" style="width:80%" type="text" name="title" :placeholder="$t('product.title')" required />
              <el-checkbox v-if="showFullItinerary" v-model="fullItinerarySpecial" style="width:20%;float:rigt">{{ $t('product.specialDescriscption') }}</el-checkbox>
            </el-form-item>
            <el-form-item v-if="showFullItinerary"><el-input v-model="fullItineraryDescription" type="textarea" name="description" :placeholder="$t('product.description')" required /></el-form-item>
            <el-form-item v-if="showFullItinerary" align="center"><el-button type="primary" @click="addFullItinerary(fullItineraryTitle, fullItineraryDescription , fullItinerarySpecial)">Done</el-button></el-form-item>
          </div>
        </el-row>

        <el-row class="fullitinerary">
          <el-row :gutter="20">
            <el-col :span="20"><el-form-item label="Things to note" /></el-col>
            <el-col :span="4"><el-button v-if="!showThingsToNote" class="pullright" type="primary" @click="showThingsToNote=true">Add</el-button></el-col>
          </el-row>
          <div v-for="(t, j) in postForm.things_to_note" :key="j" :span="24" class="fullitinerarylist">
            <label>{{ t.title }}<i slot="default" class="el-icon-close remove" title="Remove" @click="removeThingsToNote(j)" /></label>
            <p>{{ t.description }}</p>
          </div>
          <div>
            <el-form-item v-if="showThingsToNote"><el-input v-model="thingsToNoteDescription" type="textarea" name="description" :placeholder="$t('product.description')" required /></el-form-item>
            <el-form-item v-if="showThingsToNote" align="center"><el-button type="primary" @click="addThingsToNote(thingsToNoteDescription)">Done</el-button></el-form-item>
          </div>
        </el-row>
        <el-row class="fullitinerary">
          <el-row :gutter="20">
            <el-col :span="20"><el-form-item label="What's Included" /></el-col>
            <el-col :span="4"><el-button v-if="!showWhatInclude" class="pullright" type="primary" @click="showWhatInclude=true">Add</el-button></el-col>
          </el-row>
          <div v-for="(t, k) in postForm.what_included" :key="k" :span="24" class="fullitinerarylist">
            <label><img :src="storageUrl+t.icon" alt="" style="width:32px; height:32px;"><i slot="default" class="el-icon-close remove" title="Remove" @click="removeWhatInclude(k)" /></label>
            <p>{{ t.title }}</p>
          </div>
          <div>
            <el-form-item v-if="showWhatInclude">
              <el-upload class="avatar-uploader" :action="uploadFileUrl" :on-success="handleAvatarSuccess" :before-upload="beforeAvatarUpload">
                <img v-if="imageUrl" :src="imageUrl" class="avatar" width="100px">
                <i v-else class="el-icon-plus upload-icon" style="width:100px; height:100px;" />
              </el-upload>
            </el-form-item>
            <el-form-item v-if="showWhatInclude"><el-input v-model="whatIncludeTitle" type="text" name="title" :placeholder="$t('product.title')" required /></el-form-item>
            <el-form-item v-if="showWhatInclude" align="center"><el-button type="primary" @click="addWhatInclude(whatIncludeIcon, whatIncludeTitle)">Done</el-button></el-form-item>
          </div>
        </el-row>
        <el-row>
          <el-col :span="24">
            <el-form-item>
              <label>Images</label>
              <div class="image-preview">
                <div v-for="(mg, i) in postForm.fullImages" :key="mg" class="image-wrapper">
                  <i class="el-icon-delete image-action" title="Remove" @click="removeImage(i, mg)" />
                  <img :src="mg" class="pimage">
                </div>
              </div>
              <el-upload :action="uploadFileUrl" list-type="picture-card" :auto-upload="true" :on-success="handleImageSuccess">
                <i slot="default" class="el-icon-plus" />
                <div slot="file" slot-scope="{file}">
                  <img class="el-upload-list__item-thumbnail" :src="file.url" alt="">
                  <span class="el-upload-list__item-actions">
                    <span class="el-upload-list__item-preview" @click="handlePictureCardPreview(file)">
                      <i class="el-icon-zoom-in" />
                    </span>
                    <span v-if="!disabled" class="el-upload-list__item-delete" @click="handleRemove(file)">
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
import { getProductDetail, editProduct } from '@/api/product'

export default {
  name: 'UpdateProduct',
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
      productId: null,
      rules: {
        question: [{ validator: validateRequire }],
        answer: [{ validator: validateRequire }]
      },
      imageUrl: '',
      dialogImageUrl: '',
      dialogVisible: false,
      disabled: false,
      uploadFileUrl: '',
      highlight: '',
      showHighlight: false,
      fullItineraryTitle: '',
      fullItineraryDescription: '',
      fullItinerarySpecial: false,
      thingsToNoteDescription: '',
      showFullItinerary: false,
      showThingsToNote: false,
      whatIncludeIcon: '',
      whatIncludeTitle: '',
      showWhatInclude: false,
      storageUrl: '',
      tempRoute: {}
    }
  },
  computed: {
    ...mapGetters([
      'userid',
      'name',
      'usertype',
      'uploadfileurl',
      'storageurl'
    ])
  },
  watch: {
    '$route'(to, from) {
      if (to.name === 'UpdateProduct') {
        this.getDetail()
      }
    }
  },
  created() {
    this.getDetail()
  },
  methods: {
    getDetail() {
      this.uploadFileUrl = this.uploadfileurl
      this.storageUrl = this.storageurl
      this.productId = this.$route.params && this.$route.params.id
      this.postForm.fullImages = []
      getProductDetail(this.productId).then(response => {
        this.postForm = response.data.data
        this.postForm.images = this.postForm.images ? this.postForm.images : []
        this.postForm.fullImages = this.postForm.fullImages ? this.postForm.fullImages : []
      })
    },
    submitForm() {
      this.$refs.postForm.validate(valid => {
        if (valid) {
          this.loading = true
          editProduct(this.productId, this.postForm).then(response => {
            this.$message({
              title: 'success',
              message: response.data.message,
              type: 'success',
              duration: 3000
            })
            this.loading = false
            this.$router.replace({ path: '/products/index' })
          }).catch(error => {
            this.loading = false
            console.log(error, 'error')
          })
        } else {
          return false
        }
      })
    },
    addHighlight(text) {
      if (text) {
        if (this.postForm.highlights) {
          this.postForm.highlights.push(text)
        }
        this.highlight = ''
        this.showHighlight = false
      }
    },
    removeHightlight(i) {
      this.postForm.highlights.splice(i, 1)
    },
    addFullItinerary(title, description, is_special) {
      if (title && description) {
        this.postForm.fullitinerary.push({
          title: title,
          description: description,
          is_special: is_special
        })
        this.fullItineraryTitle = ''
        this.fullItineraryDescription = ''
        this.showFullItinerary = false
      }
    },
    addThingsToNote(description) {
      if (description) {
        this.postForm.things_to_note.push({
          description: description
        })
        this.thingsToNoteDescription = ''
        this.showThingsToNote = false
      }
    },
    removeFullItinerary(i) {
      this.postForm.fullitinerary.splice(i, 1)
    },
    addWhatInclude(icon, title) {
      if (icon && title) {
        this.postForm.what_included.push({
          icon: icon,
          title: title
        })
        this.whatIncludeIcon = ''
        this.whatIncludeTitle = ''
        this.showWhatInclude = false
      }
    },
    removeWhatInclude(i) {
      this.postForm.what_included.splice(i, 1)
    },
    handleAvatarSuccess(res, file) {
      this.whatIncludeIcon = res.data
      this.imageUrl = URL.createObjectURL(file.raw)
    },
    beforeAvatarUpload(file) {
      this.imageUrl = file.url
    },
    removeImage(index, img) {
      this.postForm.fullImages.splice(index, 1)
      this.postForm.images.splice(index, 1)
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
      this.postForm.images.push(file.data)
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
