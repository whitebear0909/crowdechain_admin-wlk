<template>
  <div class="app-container tablehover">
    <router-link :to="'/halloffame/add'" class="createbtn">
      <el-button type="primary" size="small" icon="el-icon-plus">Create</el-button>
    </router-link>
    <el-table v-loading="listLoading" :data="list" border fit highlight-current-row class="tablelayout" width="100%">
      <el-table-column align="center" label="Id">
        <template slot-scope="scope">
          <span>{{ scope.row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Order in home page">
        <template slot-scope="scope">
          <span>{{ scope.row.home_order }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Title">
        <template slot-scope="scope">
          <span>{{ scope.row.title }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Author">
        <template slot-scope="scope">
          <span>{{ scope.row.author }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Image">
        <template slot-scope="scope">
          <span><img v-if="scope.row.fullimgurl" :src="scope.row.fullimgurl" class="avatar" width="50px"></span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions">
        <template slot-scope="scope">
          <router-link :to="'/halloffame/edit/'+scope.row.id" class="actionhoverbtn">
            <el-button type="primary" size="small" icon="el-icon-edit" />
          </router-link>
          <el-button type="primary" size="small" icon="el-icon-delete" class="actionhoverbtn" @click="removeHalloffame(scope.row.id)" />
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { deleteHalloffame, getHalloffames } from '@/api/halloffame'

export default {
  name: 'HallofameList',
  components: { },
  filters: {
    statusFilter(status) {
      const statusMap = {
        published: 'success',
        draft: 'info',
        deleted: 'danger'
      }
      return statusMap['published']
    }
  },
  data() {
    return {
      list: null,
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20
      }
    }
  },
  watch: {
    '$route'(to, from) {
      if (to.name === 'HallofameList') {
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
      getHalloffames(this.listQuery).then(response => {
        this.list = response.data.data
        this.total = response.data.total
        this.listLoading = false
      })
    },
    removeHalloffame(id) {
      this.$confirm('This will permanently delete this record. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning'
      }).then(() => {
        deleteHalloffame(id).then(response => {
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
