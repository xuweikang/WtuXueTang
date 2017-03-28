<template>
	<section>
		<!--工具条-->
		<el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
			<el-form :inline="true" :model="filters">
				<el-form-item>
					<el-input v-model="filters.name" placeholder="姓名"></el-input>
				</el-form-item>
				<el-form-item>
					<el-button type="primary" v-on:click="getUser">查询</el-button>
				</el-form-item>
			</el-form>
		</el-col>

		<!--列表-->
		<template>
			<el-table :data="users" highlight-current-row v-loading="loading" style="width: 100%;">
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
				<el-table-column prop="email" label="邮箱地址" min-width="120" >
				</el-table-column>
				<el-table-column prop="tx_url" label="头像地址" min-width="120">
				</el-table-column>
			</el-table>
		</template>

	</section>
</template>
<script>
	import { getUserList } from '../../api/api';
	import NProgress from 'nprogress'
	export default {
		data() {
			return {
				filters: {
					name: ''
				},
				loading: false,
				users: [
				]
			}
		},
		methods: {
			//性别显示转换
			formatSex: function (row, column) {
				return row.sex == 'male' ? '男' : row.sex == 'female' ? '女' : '未知';
			},
			formatRole:function(row,column){
				return row.role == '1'? '管理员' :row.role == '2'? '学生' :'教师';
			},
			
			//获取用户列表
			getUser: function () {
				let para = {
					name: this.filters.name
				};
				this.loading = true;
				NProgress.start();
				getUserList(para).then((res) => {
					// console.log( res)
					this.users = res.data.data;
					this.loading = false;
					NProgress.done();
				});
			}
		},
		mounted() {
			this.getUser();
		}
	};

</script>

<style scoped>

</style>