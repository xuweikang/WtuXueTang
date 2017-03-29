<?php
/**
/**
 * User: xwk
 * Date: 2017/3/29
 * Time: 10:56
 */

class Model_Comment extends PhalApi_Model_NotORM{

    //递归获取评论列表
    public function getCommentList($parent_id = 0,&$result = array()){

            $arr=DI()->notorm->course_comment
                   ->select('*')
                   ->where('parent_id= ? ',$parent_id)
                   ->order("create_time desc")
                   ->fetchRows();
            if(empty($arr)){
                return array();
            }
            foreach ($arr as $cm) {
                $thisArr=&$result[];
                $cm["children"] = $this->getCommentList($cm["id"],$thisArr);
                $thisArr = $cm;
            }
            return $result;

    }

   //获取文章评论列表
    public function getComment(){
        $rs=DI()->notorm->comment_title
            ->select('*')
            ->fetchRows();
        return $rs;
    }
}