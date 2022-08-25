<template>
  <div class="app-container tablehover">
    <router-link :to="'/faq/add'" class="createbtn">
      <el-button type="primary" size="small" icon="el-icon-plus">Create</el-button>
    </router-link>
    <el-table v-loading="listLoading" :data="list" border fit highlight-current-row class="tablelayout">
      <el-table-column align="center" label="ID">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>

      <el-table-column align="left" :label="$t('faq.question')">
        <template slot-scope="scope">
          <span>{{ scope.row.question }}</span>
        </template>
      </el-table-column>

      <el-table-column align="left" :label="$t('faq.answer')">
        <template slot-scope="scope">
          <span>{{ scope.row.answer }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions">
        <template slot-scope="scope">
          <router-link :to="'/faq/edit/'+scope.row.id" class="actionhoverbtn">
            <el-button type="primary" size="small" icon="el-icon-edit" />
          </router-link>
          <el-button type="primary" size="small" icon="el-icon-delete" class="actionhoverbtn" @click="removeFaq(scope.row.id)" />
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { getFaqList, deleteFaq } from '@/api/faq'

export default {
  name: 'FaqsList',
  components: { },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger'
      }
      return statusMap['published']
    },
    userType(s) {
      return (s === 2 ? 'User' : 'Admin')
    }
  },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 10
      }
    }
  },
  watch: {
    '$route'(to, from) {
      if (to.name === 'FaqsList') {
        this.getList()
      }
    }
  },
  created() {
    this.getList()
  },
  mounted() {
  },
  methods: {
    getList() {
      this.listLoading = true
      getFaqList(this.listQuery).then(response => {
        this.list = response.data.data
        this.total = response.data.total
        this.listLoading = false
      })
    },
    removeFaq(id) {
      this.$confirm('This will permanently delete this record. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning'
      }).then(() => {
        deleteFaq(id).then(response => {
          this.$message({
            title: 'success',
            message: response.data.message,
            type: 'success',
            duration: 4000
          })
          this.getList()
        }).catch(error => {
          this.$message({
            title: 'error',
            message: error.message,
            type: 'error',
            duration: 4000
          })
        })
      }).catch(() => {})
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
@import "~@/styles/mixin.scss";
.tablelayout {
  width: 100%;
}
.tablelayout tr:hover {
  background-color: yellow;
}
.edit-input {
  padding-right: 100px;
}
.cancel-btn {
  position: absolute;
  right: 15px;
  top: 10px;
}
.createbtn {
  float: right;
  padding-bottom: 5px;
}
</style>
