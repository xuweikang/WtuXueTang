<template>
    <section>
        <!--工具条-->
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.id" placeholder="课程编号"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" v-on:click="getComments">查询</el-button>
                </el-form-item>
            </el-form>
        </el-col>
        <!--列表-->
        <el-table v-if="commentData" :data="commentData" highlight-current-row v-loading="loading"
                  @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index" width="60">
            </el-table-column>
            <el-table-column prop="course_id" label="课程编号" width="100">
            </el-table-column>
            <el-table-column prop="nickname" label="昵称" width="100">
            </el-table-column>
            <el-table-column prop="content" label="评论内容" width="400">
            </el-table-column>
            <el-table-column prop="create_time" label="评论时间" width="400">
            </el-table-column>
            <el-table-column label="操作" width="200">
                <template scope="scope">
                    <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)"
                               style='margin-left:-1px'>删除
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

        <!--工具条-->
        <el-col :span="24" class="toolbar">
            <el-button type="danger" @click="batchDel()" :disabled="this.sels.length===0">批量删除</el-button>
        </el-col>


    </section>
</template>

<script>

    import NProgress from 'nprogress'
    import { getComments,delComment,batchDelComment} from '../../api/api';

    export default {
        data() {
            return {
                filters: {
                    id: ''
                },
                loading: false,
                commentData: [],
                sels: [],//列表选中列
            }

        },
        methods: {
            formatDate1: function (row, column) {
                row.c_start = row.c_start.replace('.000000', '');
                return row.c_start;
            },
            formatDate2: function (row, column) {
                row.c_end = row.c_end.replace('.000000', '');
                return row.c_start;
            },
            formatDateExmine: function (row, column) {
                return row.c_exmine == '0' ? '待审核' : row.c_exmine == '1' ? '审核未通过' : '审核通过';
            },
            selsChange: function (sels) {
                this.sels = sels;
            },
            //获取评论列表
            getComments: function () {
                let para = {
                    c_id: this.filters.id
                };
                this.loading = true;
                NProgress.start();
                getComments(para).then((res) => {
                    // console.log( res)
                this.commentData = res.data.data;
                this.loading = false;
                NProgress.done();
            })
                ;
            },
            //删除评论
            handleDel: function (index, row) {

                this.$confirm('确认删除该评论及该下的所有回复？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                NProgress.start();
                let para = {
                    id: row.id
                };
                delComment(para).then((res) => {
                    this.listLoading = false;
                NProgress.done();
                this.$notify({
                    title: '成功',
                    message: '删除成功',
                    type: 'success'
                });
                this.getComments();
            })
                ;
            })
                ;
            },
            //批量操作
            batchDel: function () {
                let ids = this.sels.map(item => item.id).toString();
                this.$confirm('确认删除所有选中记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                NProgress.start();
                // console.log(names)
                let para = {ids: ids};
                // console.log(para)
                batchDelComment(para).then((res) => {
                    this.listLoading = false;
                NProgress.done();
                this.$notify({
                    title: '成功',
                    message: '操作成功',
                    type: 'success'
                });
                this.getComments();
            })
                ;
            }).
                catch(() => {}
                )
                ;
            }
        },
        mounted(){
            this.getComments();
        }
    }

</script>

