<?php
/**
 * Created by PhpStorm.
 * User: xwk
 * Date: 2017/3/14
 * Time: 15:39
 */
class Model_Course extends PhalApi_Model_NotORM{

    //上传课程
    public function addCourse($c_name,$c_no,$c_start,$c_end,$c_classify,$c_introduce){
        $data = array(
            'c_name'=>$c_name,
            'c_no'=>$c_no,
            'c_start'=>$c_start,
            'c_end'=>$c_end,
            'c_classify'=>$c_classify,
            'c_introduce'=>$c_introduce

        );
        $rs = DI()->notorm->course_configure
            ->insert($data);
        return $rs;
    }

    //获得所有课程列表
    public function getCoursesList($course_id)
    {
        if($course_id){
            return DI()->notorm->course_configure
                ->select('*')
                ->where('c_no= ?' , $course_id)
                ->fetchRows();
        }else{
            return DI()->notorm->course_configure
                ->select('*')
                ->fetchRows();
        }
    }


    //删除课程(根据课程id)
    public function removeCourse($course_id){
        $rs1 =DI()->notorm->course_configure
            ->where('c_no= ?',$course_id)
            ->delete();
        $rs2 =DI()->notorm->course_capter
            ->where('c_id= ?',$course_id)
            ->delete();
        $rs3 =DI()->notorm->course_unit
            ->where('c_id= ?',$course_id)
            ->delete();
        if($rs1==false || $rs2==false || $rs3==false){
            return 'delete success';
        }

    }

    //查看课程详细
    public function selectCourseDetail($course_id){
        $sql="select  kc.*  ,sp.* from course_configure kc  , course_capter sp where kc.c_no=sp.c_id AND kc.c_no='{$course_id}'";

        $rs=$this->getORM()->queryAll($sql,array());

        return $rs;
    }

    //管理员查看审核课程内容
   public function getCourseExmine($couse_id,$c_exmine){
       if($couse_id){
           $rs=DI()->notorm->course_configure
               ->select('*')
               ->where('c_exmine= ? ',$c_exmine)
               ->where('c_no= ? ',$couse_id)
               ->fetchRows();
       }else{
           $rs=DI()->notorm->course_configure
               ->select('*')
               ->where('c_exmine= ? ',$c_exmine)
               ->fetchRows();
       }
       return $rs;

   }



    //管理员审核课程  （0->审核中,1->审核未通过,2->审核通过）
    public function examineCourse($courseId,$con){
            if($con==1){
                $data=array(
                    'c_exmine'=>'1'
                );
            }
            else {
                $data=array(
                    'c_exmine'=>'2'
                );
            }

        $rs =DI()->notorm->course_configure
            ->where('c_no = ?',$courseId)
            ->update($data);
        return $rs;
    }

    //管理员批量审核课程  （0->审核中,1->审核未通过,2->审核通过）
    public function batchExamineCourse($courseNos,$con){
        if($con==1){
            $data=array(
                'c_exmine'=>'1'
            );
        }
        else {
            $data=array(
                'c_exmine'=>'2'
            );
        }
        $courseNoArr = explode(',',$courseNos);

        for($index=0;$index<count($courseNoArr);$index++){
            $rs =DI()->notorm->course_configure
                ->where('c_no = ?',$courseNoArr[$index])
                ->update($data);
        }
    }
}