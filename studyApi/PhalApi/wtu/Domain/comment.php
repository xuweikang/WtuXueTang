<?php
/**
 * User: xwk
 * Date: 2017/3/29
 * Time: 10:56
 */
class Domain_Comment
{
	//递归获取评论列表
	//

	public function getCommentList($course_id)
	{

		$model = new Model_Comment();

		$rs = $model->getCommentList($course_id);

		return $rs;
	}


	//获取文章评论列表
	public function getComment($c_id){

		$model = new Model_Comment();
		$rs = $model->getComment($c_id);
		return $rs;
	}


	//删除评论
	public function delComment($id){

		$model = new Model_Comment();
		$rs = $model -> delComment($id);
		return $rs;
	}

	//批量删除
	public function batchDelComment($ids){
		$model = new Model_Comment();
		$rs = $model -> batchDelComment($ids);
		return $rs;

	}

	//获取讨论区内容
	public function getCommentTitle($c_id){

		$model = new Model_Comment();
		$rs = $model -> getCommentTitle($c_id);
		return $rs;
	}

	//新建顶层讨论
	public function addCommentHead($course_id,$parent_id,$nickname,$creat_time,$content){

		$model = new Model_Comment();
		$rs = $model -> addCommentHead($course_id,$parent_id,$nickname,$creat_time,$content);
		return $rs;
	}
}

