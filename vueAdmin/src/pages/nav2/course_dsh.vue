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
		<el-table v-if="courseData" :data="courseData" highlight-current-row v-loading="loading" @selection-change="selsChange"style="width: 100%;">
			<el-table-column type="selection" width="55">
			</el-table-column>
			<el-table-column type="index" width="60">
			</el-table-column>
			<el-table-column prop="c_name" label="课程名" width="100" sortable>
			</el-table-column>
			<el-table-column prop="c_no" label="课程编号" width="100">
			</el-table-column>
			<el-table-column prop="c_start" label="课程开始时间" width="170" sortable :formatter="formatDate1">
			</el-table-column>
			<el-table-column prop="c_end" label="课程结束时间" width="170" sortable :formatter="formatDate2">
			</el-table-column>
			<el-table-column prop="c_classify" label="课程分类" width="100" >
			</el-table-column>
			<el-table-column prop="c_creator" label="课程作者" width="100">
			</el-table-column>
			<el-table-column prop="c_introduce" label="课程介绍" width="150" >
			</el-table-column>
			<el-table-column prop="c_exmine" label="状态" width="80" :formatter="formatDateExmine" >
			</el-table-column>
			<el-table-column label="操作" width="200">
				<template scope="scope">
					<router-link :to="{ name: 'detail', params: { course_id: scope.row.c_no }}"> <el-button size="small" >查看</el-button></router-link>
					<el-button type="success" size="small" @click="handleOption(scope.$index, scope.row,1)">通过</el-button>
					<el-button type="danger" size="small" @click="handleOption(scope.$index, scope.row,2)" style='margin-left:-1px'>不通过</el-button>
				</template>
			</el-table-column>
		</el-table>

		<!--工具条-->
		<el-col :span="24" class="toolbar">
			<el-button type="danger" @click="batchOption(2)" :disabled="this.sels.length===0">批量通过</el-button>
			<el-button type="danger" @click="batchOption(1)" :disabled="this.sels.length===0">批量不通过</el-button>
		</el-col>



	</section>
</template>

<script>

	import NProgress from 'nprogress'
	import { getCourseExmine,examineCourse,batchExamineCourse} from '../../api/api';

	export default {
		data() {
			return {
				filters: {
					id: ''
				},
				loading: false,
				courseData: [],
				sels: [],//列表选中列
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
			formatDateExmine:function(row,column){
				return row.c_exmine == '0'? '待审核' :row.c_exmine == '1'? '审核未通过' :'审核通过';
			},
			selsChange: function (sels) {
				this.sels = sels;
			},
          //获取待审核用户列表
          getCourses: function () {
          	let para = {
          		course_id: this.filters.id,
          		c_exmine:0
          	};
          	this.loading = true;
          	NProgress.start();
          	getCourseExmine(para).then((res) => {
          // console.log( res)
          this.courseData = res.data.data;
          this.loading = false;
          NProgress.done();
      });
          },
          //通过 or 不通过审核
          handleOption:function(index,row,opt){
            if(opt==1)  //执行通过操作
            {
            	this.$confirm('通过该课程的审核？', '提示', {
            		type: 'warning'
            	}).then(() => {
            		this.listLoading = true;
            		NProgress.start();
            		let para = { 
            			course_id: row.c_no ,
            			option:2
            		};
            		examineCourse(para).then((res) => {
            			this.listLoading = false;
            			NProgress.done();
            			this.$notify({
            				title: '成功',
            				message: '操作成功',
            				type: 'success'
            			});
            			this.getCourses();
            		});
            	});
            }
            else   //执行不通过操作
            {
            		this.$confirm('不通过该课程的审核？', '提示', {
            		type: 'warning'
            	}).then(() => {
            		this.listLoading = true;
            		NProgress.start();
            		let para = { 
            			course_id: row.c_no ,
            			option:1
            		};
            		examineCourse(para).then((res) => {
            			this.listLoading = false;
            			NProgress.done();
            			this.$notify({
            				title: '成功',
            				message: '操作成功',
            				type: 'success'
            			});
            			this.getCourses();
            		});
            	}).catch(() => {

            	});

            }
        },
          //批量操作
          batchOption:function(opt){
            let couseNos=this.sels.map(item => item.c_no).toString();
            	this.$confirm('确认执行所有选中记录吗？', '提示', {
					type: 'warning'
				}).then(() => {
					this.listLoading = true;
					NProgress.start();
					// console.log(names)
					let para = { courseNos: couseNos,option:opt };
					// console.log(para)
					batchExamineCourse(para).then((res) => {
						this.listLoading = false;
						NProgress.done();
						this.$notify({
							title: '成功',
							message: '操作成功',
							type: 'success'
						});
						this.getCourses();
					});
				}).catch(() => {

				 });
          }
      },
      mounted(){
      	this.getCourses();
      }
  }

</script>

