<template>
	<section>
		<!--工具条-->
		<el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
			<el-form :inline="true" :model="filters">
				<el-form-item>
					<el-input v-model="filters.name" placeholder="姓名"></el-input>
				</el-form-item>
				<el-form-item>
					<el-button type="primary" v-on:click="getUsers">查询</el-button>
				</el-form-item>
				<el-form-item>
					<el-button type="primary" @click="handleAdd">新增</el-button>
				</el-form-item>
			</el-form>
		</el-col>
		<!--列表-->
		<el-table v-if="users" :data="users" highlight-current-row v-loading="listLoading" @selection-change="selsChange" style="width: 100%;">
			<el-table-column type="selection" width="55">
			</el-table-column>
			<el-table-column type="index" width="60">
			</el-table-column>
			<el-table-column prop="name" label="用户名" width="100" sortable>
			</el-table-column>
			<el-table-column prop="user_pwd" label="用户密码" width="120">
			</el-table-column>
			<el-table-column prop="sex" label="性别" width="100" :formatter="formatSex" sortable>
			</el-table-column>
			<el-table-column prop="role" label="角色" width="120" sortable :formatter="formatRole">
			</el-table-column>
			<el-table-column prop="email" label="邮箱地址" min-width="180" sortable>
			</el-table-column>
			<el-table-column prop="tx_url" label="头像地址" min-width="180" sortable>
			</el-table-column>
			<el-table-column label="操作" width="150">
				<template scope="scope">
					<el-button size="small" @click="handleEdit(scope.$index, scope.row)">编辑</el-button>
					<el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)">删除</el-button>
				</template>
			</el-table-column>
		</el-table>

		<!--工具条-->
		<el-col :span="24" class="toolbar">
			<el-button type="danger" @click="batchRemove" :disabled="this.sels.length===0">批量删除</el-button>
			<el-pagination layout="prev, pager, next" @current-change="handleCurrentChange" :page-size="10" :total="1000" style="float:right;">
			</el-pagination>
		</el-col>

		<!--编辑界面-->
		<el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
			<el-form :model="editForm" label-width="80px" :rules="editFormRules" ref="editForm">
				<el-form-item label="用户名" prop="name">
					<el-input v-model="editForm.name" auto-complete="off"></el-input>
				</el-form-item>
				<el-form-item label="用户密码" prop="user_pwd" label-width="82px">
					<el-input v-model="editForm.user_pwd" auto-complete="off"></el-input>
				</el-form-item>
				<el-form-item label="性别" prop="sex">
					<el-radio-group v-model="editForm.sex">
						<el-radio class="radio" :label="1">男</el-radio>
						<el-radio class="radio" :label="0">女</el-radio>
					</el-radio-group>
				</el-form-item>
				<el-form-item label="角色" prop="role">
					<el-radio-group v-model="editForm.role">
						<el-radio class="radio" :label="3">管理员</el-radio>
						<el-radio class="radio" :label="6">学生</el-radio>
						<el-radio class="radio" :label="9">教师</el-radio>
					</el-radio-group>
				</el-form-item>
				<el-form-item label="邮箱地址" prop="email" label-width="82px">
					<el-input v-model="editForm.email" auto-complete="off" ></el-input>
				</el-form-item>
			</el-form>
			<div slot="footer" class="dialog-footer">
				<el-button @click.native="editFormVisible = false">取消</el-button>
				<el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
			</div>
		</el-dialog>

		<!--新增界面-->
		<el-dialog title="新增" v-model="addFormVisible" :close-on-click-modal="false">
			<el-form :model="addForm" label-width="80px" :rules="addFormRules" ref="addForm">
				<el-form-item label="用户名" prop="name">
					<el-input v-model="addForm.name" auto-complete="off"></el-input>
				</el-form-item>
				<el-form-item label="密码" prop="user_pwd">
					<el-input v-model="addForm.user_pwd" auto-complete="off"></el-input>
				</el-form-item>
				<el-form-item label="性别" prop="sex">
					<el-radio-group v-model="addForm.sex">
						<el-radio class="radio" :label="1">男</el-radio>
						<el-radio class="radio" :label="0">女</el-radio>
					</el-radio-group>
				</el-form-item>
				<el-form-item label="角色" prop="role">
					<el-radio-group v-model="addForm.role">
						<el-radio class="radio" :label="3">管理员</el-radio>
						<el-radio class="radio" :label="6">学生</el-radio>
						<el-radio class="radio" :label="9">教师</el-radio>
					</el-radio-group>
				</el-form-item>
				<el-form-item label="邮箱地址" prop="email" label-width="82px">
					<el-input v-model="addForm.email" auto-complete="off" ></el-input>
				</el-form-item>

			</el-form>
			<div slot="footer" class="dialog-footer">
				<el-button @click.native="addFormVisible = false">取消</el-button>
				<el-button type="primary" @click.native="addSubmit" :loading="addLoading">提交</el-button>
			</div>
		</el-dialog>
	</section>
</template>

<script>
	import util from '../../common/js/util'
	import NProgress from 'nprogress'
	import { getUserListPage, removeUser, batchRemoveUser, editUser, addUser } from '../../api/api';

	export default {
		data() {
			return {
				filters: {
					name: ''
				},
				users: [],
				total: 0,
				page: 1,
				listLoading: false,
				sels: [],//列表选中列

				editFormVisible: false,//编辑界面是否显示
				editLoading: false,
				editFormRules: {
					name: [
						{ required: true, message: '请输入姓名', trigger: 'blur' }
					],
					user_pwd: [
						{ required: true, message: '请输入密码', trigger: 'blur' }
					],
					email: [
						{ required: true, message: '请输入注册邮箱', trigger: 'blur' }
					]
				},
				//编辑界面数据
				editForm: {
					name: '',
					user_pwd: '',
					sex: '',
					role: '',
					email: '',
					tx_url:''
				},
			

				addFormVisible: false,//新增界面是否显示
				addLoading: false,
				addFormRules: {
					name: [
						{ required: true, message: '请输入姓名', trigger: 'blur' }
					],
					user_pwd: [
						{ required: true, message: '请输入密码', trigger: 'blur' }
					],
					email: [
						{ required: true, message: '请输入注册邮箱', trigger: 'blur' }
					]
				},
				//新增界面数据
				addForm: {
					name: '',
					user_pwd: '',
					sex: '',
					role: '',
					email: '',
					tx_url:''
				}

			}
		},
		methods: {
			//性别显示转换
			formatSex: function (row, column) {
				return row.sex == 'male' ? '男' : row.sex == 'female' ? '女' : '未知';
			},
			//角色转换
			formatRole:function (row,colum){
				return row.role == '1'? '管理员' :row.role == '2'? '学生' :'教师';
			},
			handleCurrentChange(val) {
				this.page = val;
				this.getUsers();
			},
			//获取用户列表
			getUsers() {
				let para = {
					page: this.page,
				    name: this.filters.name
				};
				// console.log(name)
				this.listLoading = true;
				NProgress.start();
				getUserListPage(para).then((res) => {
	
//                   console.log(res['data']['data'].length)
					this.users =res['data']['data'];

					this.listLoading = false;
					NProgress.done();

				});
			},
			//删除
			handleDel: function (index, row) {
				this.$confirm('确认删除该记录吗?', '提示', {
					type: 'warning'
				}).then(() => {
					this.listLoading = true;
					NProgress.start();
					let para = { name: row.name };
					removeUser(para).then((res) => {
						this.listLoading = false;
						NProgress.done();
						this.$notify({
							title: '成功',
							message: '删除成功',
							type: 'success'
						});
						this.getUsers();
					});
				}).catch(() => {

				});
			},
			//显示编辑界面
			handleEdit: function (index, row) {
				this.editFormVisible = true;
				//编辑界面的性别和角色数据转换
				 var sex= row.sex == 'male'? 1:0;
				 console.log(row)
				 var role=row.role=='1'?3:row.role=='2'?6:9;
				this.editForm = Object.assign({}, row);
				this.editForm.sex=sex;
				this.editForm.role=role;
			
//				console.log(row);
			},
			//显示新增界面
			handleAdd: function () {
				this.addFormVisible = true;
				this.addForm = {
					name: '',
					user_pwd: '',
					sex:0,
					role: 3,
					email: '',
					tx_url: ''
				};
			},
			//编辑
			editSubmit: function () {
				this.$refs.editForm.validate((valid) => {
					if (valid) {
						this.$confirm('确认提交吗？', '提示', {}).then(() => {
							this.editLoading = true;
							NProgress.start();
							let para = Object.assign({}, this.editForm);
							para.role= para.role== '3'? 1 :para.role == '6'? 2 :3;
							para.sex= para.sex== '1'?'male':'female';
						
							editUser(para).then((res) => {
								console.log(res)
								this.editLoading = false;
								NProgress.done();
								this.$notify({
									title: '成功',
									message: '修改成功',
									type: 'success'
								});
								this.$refs['editForm'].resetFields();
								this.editFormVisible = false;
								this.getUsers();
							});
						});
					}
				});
			},
			//新增
			addSubmit: function () {
				this.$refs.addForm.validate((valid) => {
					if (valid) {
						this.$confirm('确认提交吗？', '提示', {}).then(() => {
							this.addLoading = true;
							NProgress.start();
							//Object.assign() 方法用于将所有可枚举的属性的值从一个或多个源对象复制到目标对象。它将返回目标对象。
							let para = Object.assign({}, this.addForm);
							para.role= para.role== '3'? 1 :para.role == '6'? 2 :3;
							para.sex= para.sex== '1'?'male':'female';
							addUser(para).then((res) => {
								// console.log(res)
								this.addLoading = false;
								NProgress.done();
								this.$notify({
									title: '成功',
									message: '提交成功',
									type: 'success'
								});
								this.$refs['addForm'].resetFields();
								this.addFormVisible = false;
								this.getUsers();
							});
						});
					}
				});
			},
			selsChange: function (sels) {
				this.sels = sels;
			},
			//批量删除
			batchRemove: function () {
				var names = this.sels.map(item => item.name).toString();
				this.$confirm('确认删除选中记录吗？', '提示', {
					type: 'warning'
				}).then(() => {
					this.listLoading = true;
					NProgress.start();
					// console.log(names)
					let para = { names: names };
					batchRemoveUser(para).then((res) => {
						this.listLoading = false;
						NProgress.done();
						this.$notify({
							title: '成功',
							message: '删除成功',
							type: 'success'
						});
						this.getUsers();
					});
				}).catch(() => {

				 });
			 }
		},
		mounted() {
			this.getUsers();
		}
	}

</script>

<style scoped>

</style>