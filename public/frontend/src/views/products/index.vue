<template>
  <div class="app-container tablehover">
    <router-link :to="'/product/add'" class="createbtn">
      <el-button type="primary" size="small" icon="el-icon-plus">Create</el-button>
    </router-link>
    <el-table v-loading="listLoading" :data="list" border fit highlight-current-row class="tablelayout">
      <el-table-column align="center" label="ProductID">
        <template slot-scope="scope">
          <span>{{ scope.row.product_id }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="Priorità">
        <template slot-scope="scope">
          <span>{{ scope.row.priority }}</span>
        </template>
      </el-table-column>

      <el-table-column align="left" :label="$t('product.name')">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="left" :label="$t('product.productcode')">
        <template slot-scope="scope">
          <span>{{ scope.row.product_code }}</span>
        </template>
      </el-table-column>

      <el-table-column align="left" label="Url Friendly">
        <template slot-scope="scope">
          <span>{{ scope.row.url_personalizzato }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions">
        <template slot-scope="scope">
          <router-link :to="'/product/edit/'+scope.row.id" class="actionhoverbtn">
            <el-button type="primary" size="small" icon="el-icon-edit" />
          </router-link>
          <el-button type="primary" size="small" icon="el-icon-delete" class="actionhoverbtn" @click="removeProduct(scope.row.id)" />
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { getProductList, deleteProduct } from '@/api/product'

export default {
  name: 'ProductsList',
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
        limit: 50
      }
    }
  },
  watch: {
    '$route'(to, from) {
      if (to.name === 'ProductsList') {
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
      getProductList(this.listQuery).then(response => {
        this.list = response.data.data
        this.total = response.data.total
        this.listLoading = false
      })
    },
    removeProduct(id) {
      this.$confirm('This will permanently delete this record. Continue?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Cancel',
        type: 'warning'
      }).then(() => {
        deleteProduct(id).then(response => {
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
