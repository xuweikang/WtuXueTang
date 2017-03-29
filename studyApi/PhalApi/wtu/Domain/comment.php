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

	public function getCommentList()
	{

		$model = new Model_Comment();

		$rs = $model->getCommentList();

		return $rs;
	}
}

