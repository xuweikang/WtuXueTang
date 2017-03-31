<template>
    <section>
        <!--工具条-->
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.id" placeholder="课程编号"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" v-on:click="getExercise">查询</el-button>
                </el-form-item>
            </el-form>
        </el-col>
        <!--列表-->
        <el-table v-if="exerciseData" :data="exerciseData" highlight-current-row v-loading="loading"
                  @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index" width="60">
            </el-table-column>
            <el-table-column prop="c_id" label="课程编号" width="100">
            </el-table-column>
            <el-table-column prop="content" label="习题名称" width="300">
            </el-table-column>
            <el-table-column prop="right_option" label="习题答案" width="120">
            </el-table-column>
            <el-table-column prop="option_1" label="选项一" width="120">
            </el-table-column>
            <el-table-column prop="option_2" label="选项二" width="120">
            </el-table-column>
             <el-table-column prop="option_3" label="选项三" width="120">
            </el-table-column>
             <el-table-column prop="score" label="分值" width="80">
            </el-table-column>
            <el-table-column label="操作" width="200">
                <template scope="scope">
                    <el-button size="small" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
                    <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)"
                               style='margin-left:-1px'>删除
                    </el-button>
                </template>
            </el-table-column>
        </el-table>

            <!--编辑界面-->
        <el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="80px" :rules="editFormRules" ref="editForm">
                <el-form-item label="课程编号" prop="c_id">
                    <el-input v-model="editForm.c_id" auto-complete="off" disabled></el-input>
                </el-form-item>
                <el-form-item label="题目" prop="content" label-width="82px">
                    <el-input v-model="editForm.content" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="正确答案" prop="right_option" >
                     <el-input v-model="editForm.right_option" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="选项一" prop="option_1">
                   <el-input v-model="editForm.option_1" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="选项二" prop="option_2">
                   <el-input v-model="editForm.option_2" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="选项三" prop="option_3">
                   <el-input v-model="editForm.option_3" auto-complete="off"></el-input>
                </el-form-item>
                <el-form-item label="分值" prop="score" label-width="82px">
                    <el-input v-model="editForm.score" auto-complete="off" ></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>

        <!--工具条-->
        <el-col :span="24" class="toolbar">
            <el-button type="danger" @click="batchDel()" :disabled="this.sels.length===0">批量删除</el-button>
        </el-col>


    </section>
</template>

<script>

    import NProgress from 'nprogress'
    import { getExercise,delExercise,batchDelExercise,updateExercise} from '../../api/api';

    export default {
        data() {
            return {
                filters: {
                    id: ''
                },
                loading: false,
                editLoading: false,
                exerciseData: [],
                sels: [],//列表选中列
                editFormVisible: false,//编辑界面是否显示
                    //编辑界面数据
                editForm: {
                    c_id: '',
                    content: '',
                    right_option: '',
                    option_1: '',
                    option_2: '',
                    option_3:'',
                    score:''
                },
                    editFormRules: {
                    content: [
                        { required: true, message: '请输入题目', trigger: 'blur' }
                    ],
                    right_option: [
                        { required: true, message: '请输入正确答案', trigger: 'blur' }
                    ],
                    option_1: [
                        { required: true, message: '请输入错误选项一', trigger: 'blur' }
                    ],
                     option_2: [
                        { required: true, message: '请输入错误选项二', trigger: 'blur' }
                    ],
                     option_3: [
                        { required: true, message: '请输入错误选项三', trigger: 'blur' }
                    ],
                     score: [
                        { required: true, message: '请输入该题分值', trigger: 'blur' }
                    ]
                },
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
            //获取待审核用户列表
            getExercise: function () {
                let para = {
                    c_id: this.filters.id
                };
                this.loading = true;
                NProgress.start();
                getExercise(para).then((res) => {
                    // console.log( res)
                    this.exerciseData = res.data.data;
                this.loading = false;
                NProgress.done();
            })
                ;
            },
                //显示编辑界面
            handleEdit: function (index, row) {
                this.editFormVisible = true;

                this.editForm = Object.assign({}, row);
            
//              console.log(row);
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
                delExercise(para).then((res) => {
                    this.listLoading = false;
                NProgress.done();
                this.$notify({
                    title: '成功',
                    message: '删除成功',
                    type: 'success'
                });
                this.getExercise();
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
                batchDelExercise(para).then((res) => {
                    this.listLoading = false;
                NProgress.done();
                this.$notify({
                    title: '成功',
                    message: '操作成功',
                    type: 'success'
                });
                this.getExercise();
            })
                ;
            }).
                catch(() => {}
                )
                ;
            },
            //编辑
            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            NProgress.start();
                            let para = Object.assign({}, this.editForm);
                            // console.log(para);
                            updateExercise(para).then((res) => {
                                this.editLoading = false;
                                NProgress.done();
                                this.$notify({
                                    title: '成功',
                                    message: '修改成功',
                                    type: 'success'
                                });
                                this.$refs['editForm'].resetFields();
                                this.editFormVisible = false;
                                this.getExercise();
                            });
                        });
                    }
                });
            },
        },
        mounted(){
            this.getExercise();
        }
    }

</script>

