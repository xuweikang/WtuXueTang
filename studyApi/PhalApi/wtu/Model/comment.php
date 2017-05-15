<?php
/**
/**
 * User: xwk
 * Date: 2017/3/29
 * Time: 10:56
 */

class Model_Comment extends PhalApi_Model_NotORM{

    //递归获取评论列表
    public function getCommentList($course_id,$parent_id = 0,&$result = array()){

            $arr=DI()->notorm->course_comment
                   ->select('*')
                   ->where('parent_id= ? ',$parent_id)
                   ->where('course_id=?',$course_id)
                   ->order("create_time desc")
                   ->fetchRows();
            if(empty($arr)){
                return array();
            }
            foreach ($arr as $cm) {
                $thisArr=&$result[];
                $cm["children"] = $this->getCommentList($course_id,$cm["id"],$thisArr);
                $thisArr = $cm;
            }
            return $result;

    }

   //获取文章评论列表
    public function getComment($c_id){
        if($c_id){
            $rs=DI()->notorm->comment_title
                ->select('*')
                ->where("c_id = ?",$c_id)
                ->fetchRows();
        }else{
            $rs=DI()->notorm->comment_title
                ->select('*')
                ->order("c_id desc")
                ->fetchRows();
        }
        return $rs;
    }

    //删除评论
    public function delComment($id){
        $rs1=DI()->notorm->comment_title
            ->where('id= ?',$id)
            ->delete();
        $rs2=DI()->notorm->course_comment
            ->where('comment_id= ?',$id)
            ->delete();

        if($rs1==false || $rs2==false){
            return 'delete error';
        }else{
            return 'delete success';
        }
    }

    //批量删除
    public function batchDelComment($ids){

        $idArr = explode(',',$ids);
        for($index=0;$index<count($idArr);$index++){
            $rs1 =DI()->notorm->comment_title
                ->where('id= ?',$idArr[$index])
                ->delete();
            $rs2=DI()->notorm->course_comment
                ->where('comment_id= ?',$idArr[$index])
                ->delete();
        }
    }


    //获取讨论区内容
    public function getCommentTitle($c_id){

        return DI()->notorm->comment_title
            ->select('*')
            ->where("c_id = ?",$c_id)
            ->fetchRows();
    }

    //新建顶层讨论
    public function addCommentHead($course_id,$parent_id,$nickname,$create_time,$content){

        $data = array(
            'course_id'=>$course_id,
            'parent_id'=>$parent_id,
            'nickname'=>$nickname,
            'create_time'=>$create_time,
            'content'=>$content
        );
        $rs = DI()->notorm->course_comment
            ->insert($data);
        return $rs;
    }
}