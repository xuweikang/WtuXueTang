<template>
	<section>

		<el-table v-if="courseData" :data="data" highlight-current-row  style="width: 100%;">

			<el-table-column prop="c_name" label="课程" width="100">
			</el-table-column>
			<el-table-column prop="c_no" label="编号" width="100">
			</el-table-column>
			<el-table-column prop="c_creator" label="老师" width="100">
			</el-table-column>
			<el-table-column prop="c_introduce" label="课程介绍" width="160">
			</el-table-column>
			<el-table-column prop="c_classify" label="类别" width="100" >
			</el-table-column>
			<el-table-column prop="c_start" label="开始时间" width="180" :formatter="formatDate1">
			</el-table-column>
			<el-table-column prop="c_end" label="结束时间" width="180" :formatter="formatDate2">
			</el-table-column>
			<el-table-column prop="c_exmine" label="审核状态" width="180" :formatter="shenghe">
			</el-table-column>
		</el-table>
		<el-collapse >
			<div v-for="(item, index) in courseDataBl" >
				<el-collapse-item :title='item[1]' :name='index'>
					{{item[2]}}
					<br>
					<video :src='item[3]' controls="controls"></video>
				</el-collapse-item>
			</div>
</el-collapse>

</section>
</template>
<style>
	.creator{
		color: red;
		margin-left: 37px;
		font-size: 13px;
	}
	.time{
		color: red;
	}
</style>
<script>
	import NProgress from 'nprogress';
	import { getCourseDetail} from '../../api/api';

	export default {
		data(){
			return {
				data:[],
				courseData:{},
				courseDataBl:[]

			}
		},
		methods:{
			formatDate1:function (row, column) {
				row.c_start = row.c_start.replace('.000000','') ;
				return row.c_start;
			},
			formatDate2:function (row, column) {
				row.c_end = row.c_end.replace('.000000','') ;
				return row.c_end;
			},
			shenghe:function(row){
				return row.c_exmine == '0'? '审核中' :row.c_exmine == '1'? '审核未通过' :'审核通过';
			},
			getCoursesDetail:function(){
				this.loading = true;
				NProgress.start();
				getCourseDetail(this.$route.params).then((res) => {
					// console.log( res)
					let [c_creator,c_name,c_no,content,c_start,c_end,c_classify,c_introduce,c_exmine] = res.data.data;
					this.courseData={
						c_creator:c_creator,
						c_name:c_name,
						c_no:c_no,
						content:content,
						c_start:c_start,
						c_end:c_end,
						c_classify:c_classify,
						c_introduce:c_introduce,
						c_exmine:c_exmine
					};
					this.data[0]=this.courseData;
					this.courseDataBl=this.courseData.content[c_no];
	

					NProgress.done();
				});
			}
		},
		mounted(){
			this.getCoursesDetail();
		}
	}
	

</script>