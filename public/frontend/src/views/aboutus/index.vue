<template>
  <div class="app-container tablehover">
    <router-link v-if="!aboutusData" :to="'/about/edit'" class="createbtn">
      <el-button type="primary" size="small" icon="el-icon-plus">Add about</el-button>
    </router-link>
    <div v-if="!aboutusData" align="center">
      There is no data added
    </div>
    <el-table v-if="aboutusData" v-loading="listLoading" :data="[aboutusData]" border fit highlight-current-row class="tablelayout">
      <el-table-column width="900px" align="left" :placeholder="$t('user.username')">
        <template slot-scope="scope">
          {{ scope.row.text }}
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="100">
        <template slot-scope="scope">
          <router-link :to="'/about/edit/'+scope.row.id" class="actionhoverbtn">
            <el-button type="primary" size="small" icon="el-icon-edit" />
          </router-link>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { getAboutUs } from '@/api/faq'

export default {
  name: 'AboutUs',
  components: { },
  filters: {
  },
  data() {
    return {
      aboutusData: null,
      total: 0,
      listLoading: true
    }
  },
  watch: {
    '$route'(to, from) {
      if (to.name === 'AboutUs') {
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
      getAboutUs().then(response => {
        this.aboutusData = response.data.data
        this.listLoading = false
      })
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
