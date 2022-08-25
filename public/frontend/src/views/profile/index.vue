<template>
  <div class="profile-container">
    <el-row id="uploaProfile12" style="text-align:center;">
      <el-upload
        v-if="!dialogVisible"
        :action="uploadUrl"
        list-type="picture-card"
        :on-preview="handlePictureCardPreview"
        :on-remove="handleRemove"
      >
        <i class="el-icon-plus" />
      </el-upload>
      <el-dialog :visible.sync="dialogVisible">
        <img width="100%" :src="profileImageUrl" alt="">
      </el-dialog>
    </el-row>
    <el-form ref="ruleForm" :model="ruleForm" :rules="rules" label-width="120px" class="profile-update">
      <el-form-item label="Name" prop="name">
        <el-input v-model="ruleForm.name" />
      </el-form-item>
      <el-form-item label="D.O.B." prop="dob" required>
        <el-col :span="24">
          <el-form-item prop="date">
            <el-date-picker v-model="ruleForm.dob" type="date" placeholder="Date of birth" style="width: 100%;" />
          </el-form-item>
        </el-col>
      </el-form-item>
      <el-form-item label="Gender">
        <el-radio-group v-model="ruleForm.gender">
          <el-radio :label="1">Male</el-radio>
          <el-radio :label="2">Female</el-radio>
        </el-radio-group>
      </el-form-item>
      <el-form-item label="Mobile" prop="mobile">
        <el-input v-model="ruleForm.mobile" />
      </el-form-item>
      <el-form-item label="About me" prop="introduction">
        <el-input v-model="ruleForm.introduction" type="textarea" />
      </el-form-item>
      <el-form-item align="center" style="margin-left: 0px;">
        <el-button @click="updateProfileMode=false">Cancel</el-button>
        <el-button type="primary" @click="submitForm()">Update</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { getProfile, updateProfile } from '@/api/profile'

export default {
  name: 'Profile',
  components: { },
  data() {
    return {
      uploadUrl: '',
      dialogVisible: false,
      profileImageUrl: '',
      ruleForm: {
        name: '',
        dob: '',
        gender: '',
        mobile: '',
        introduction: ''
      },
      rules: {
        name: [
          { required: true, message: 'Please enter your name', trigger: 'blur' },
          { min: 2, max: 100, message: 'Length should be 2 to 100', trigger: 'blur' }
        ],
        dob: [
          { required: true, message: 'Please select your date of birth', trigger: 'change' }
        ],
        mobile: [
          { required: true, message: 'Please enter your mobile number', trigger: 'blur' },
          { min: 10, max: 14, message: 'Please correct mobile number', trigger: 'blur' }
        ],
        introduction: [
          { required: true, message: 'Please write something about you', trigger: 'blur' }
        ]
      },
      updateProfileMode: true,
      loading: true
    }
  },
  computed: {
    ...mapGetters([
      'apiurl',
      'token'
    ])
  },
  watch: {
    '$route': 'getUserProfile'
  },
  created() {
    this.getUserProfile()
  },
  methods: {
    getUserProfile() {
      this.loading = true
      this.uploadUrl = ''
      getProfile().then(response => {
        this.ruleForm = response.data.data
        this.loading = false
        this.uploadUrl = this.apiurl + 'profile/upload?token=' + this.token
      })
    },
    submitForm() {
      this.$refs.ruleForm.validate(valid => {
        if (valid) {
          this.loading = true
          updateProfile(this.ruleForm).then(response => {
            this.updateProfileMode = false
            this.loading = false
            this.$message({
              title: 'success',
              message: response.data.message,
              type: 'success',
              duration: 3000
            })
          }).catch(error => {
            console.log(error, 'error')
            this.loading = false
          })
        } else {
          console.log('error submit!!')
          this.loading = false
          return false
        }
      })
    },
    handleRemove(file, fileList) {
      console.log(file, fileList)
    },
    handlePictureCardPreview(file) {
      this.profileImageUrl = file.url
      this.dialogVisible = true
    }
  }

}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
@import "~@/styles/mixin.scss";
.profile-container {
  padding: 10px;
}
#uploaProfile {
  text-align: center;
  width: 220px;
  height: 220px;
  margin: auto;
  border: 1px solid #eee;
  border-radius: 50%;
  background-color: #eee;
  margin-bottom: 20px;
}
.avatar-uploader .el-upload {
  border: 1px dashed #d9d9d9;
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
}
.avatar-uploader .el-upload:hover {
  border-color: #409EFF;
}
.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  line-height: 220px;
  text-align: center;
}
.avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>
