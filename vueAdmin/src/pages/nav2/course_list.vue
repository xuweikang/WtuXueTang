<template>
  <section>
    <!--工具条-->
    <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
      <el-form :inline="true" :model="filters">
        <el-form-item>
          <el-input v-model="filters.id" placeholder="课程编号"></el-input>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" v-on:click="getCourses">查询</el-button>
        </el-form-item>
      </el-form>
    </el-col>

    <!--列表-->
    <template>
      <el-table :data="courseData" highlight-current-row v-loading="loading" style="width: 100%;" >
        <el-table-column type="index" width="60">
        </el-table-column>
        <el-table-column prop="c_name" label="课程名" width="100" sortable>
        </el-table-column>
        <el-table-column prop="c_no" label="课程编号" width="120">
        </el-table-column>
        <el-table-column prop="c_start" label="课程开始时间" width="200" sortable :formatter="formatDate1">
        </el-table-column>
        <el-table-column prop="c_end" label="课程结束时间" width="200" sortable :formatter="formatDate2">
        </el-table-column>
        <el-table-column prop="c_classify" label="课程分类" width="100" >
        </el-table-column>
        <el-table-column prop="c_creator" label="课程作者" width="120">
        </el-table-column>
        <el-table-column prop="c_introduce" label="课程介绍" width="500" >
        </el-table-column>
        <el-table-column label="操作" width="150" fixed='right' >
          <template scope="scope">
         
          <router-link :to="{ name: 'detail', params: { course_id: scope.row.c_no }}"> <el-button size="small" >查看</el-button></router-link>
          <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)">删除</el-button>

        </template>
      </el-table-column>
    </el-table>
  </template>

</section>
</template>
<script>
  import { getCourseList,removeCourse } from '../../api/api';
  import NProgress from 'nprogress'
  export default {
    data() {
      return {
        filters: {
          id: ''
        },
        loading: false,
        courseData: [
        ]
      }
    },
    methods: {
      formatDate1:function (row, column) {
        row.c_start = row.c_start.replace('.000000','') ;
        return row.c_start;
      },
      formatDate2:function (row, column) {
        row.c_end = row.c_end.replace('.000000','') ;
        return row.c_start;
      },
      //查看课程
      handleFind:function(index,row){
   
      },
        //删除
        handleDel: function (index, row) {
          this.$confirm('该操作将会删除该课程下的所有内容！继续操作吗？', '提示', {
            type: 'warning'
          }).then(() => {
            this.listLoading = true;
            NProgress.start();
            let para = { course_id: row.c_no };
            removeCourse(para).then((res) => {
              this.listLoading = false;
              NProgress.done();
              this.$notify({
                title: '成功',
                message: '删除成功',
                type: 'success'
              });
              this.getCourses();
            });
          }).catch(() => {

          });
        },
      //获取用户列表
      getCourses: function () {
        let para = {
          c_no: this.filters.id
        };
        this.loading = true;
        NProgress.start();
        getCourseList(para).then((res) => {
           // console.log( res)
          this.courseData = res.data.data;
          this.loading = false;
          NProgress.done();
        });
      }
    },
    mounted() {
      this.getCourses();
    }
  };

</script>
