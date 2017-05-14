<?php
/**
 * Created by PhpStorm.
 * User: xwk
 * Date: 2017/3/14
 * Time: 15:44
 */
class Domain_Course{
    //上传课程
    public function addCourse($c_name,$c_no,$c_start,$c_end,$c_classify,$c_introduce,$c_img){
        $data = array(
            'c_name'=>$c_name,
            'c_no'=>$c_no,
            'c_start'=>$c_start,
            'c_end'=>$c_end,
            'c_classify'=>$c_classify,
            'c_introduce'=>$c_introduce,
            'c_img'=>$c_img

        );
        $model=new Model_Course();
        $rs=$model->addCourse($c_name,$c_no,$c_start,$c_end,$c_classify,$c_introduce,$c_img);
        return $rs;
    }

    //获得所有课程列表
    public function getCoursesList($course_id)
    {
        $model=new Model_Course();
        $rs=$model->getCoursesList($course_id);

        return $rs;
    }

    //删除课程(根据课程id)
    public function removeCourse($course_id){

        $model=new Model_Course();
        $rs=$model->removeCourse($course_id);
        return $rs;
    }

    //查看课程详细
    public function selectCourseDetail($course_id){

        $model=new Model_Course();
        $rs=$model->selectCourseDetail($course_id);
//        return $rs;

        //将查询数据格式化前台能够解析的格式
        $cc=array();
        $rss=array();
        $c2=array();
        foreach($rs as $obj){
            $c1=array();
            $c1[]=$obj['id'];
            $c1[]=$obj['c_content'];
            $c1[]=$obj['capter_introduce'];
            $c1[]=$obj['c_url'];
            $cc[$obj['capter_id']]=$c1;
        }
        $c2[$rs[0]['c_no']]=$cc;
        $rss[]=$rs[0]['c_creator'];
        $rss[]=$rs[0]['c_name'];
        $rss[]=$rs[0]['c_no'];
        $rss[]=$c2;
        $rss[]=$rs[0]['c_start'];
        $rss[]=$rs[0]['c_end'];
        $rss[]=$rs[0]['c_classify'];
        $rss[]=$rs[0]['c_introduce'];
        $rss[]=$rs[0]['c_exmine'];
        return $rss;
    }

    //管理员查看审核课程内容
    public function getCourseExmine($couse_id,$c_exmine){

        $model=new Model_Course();
        $rs=$model->getCourseExmine($couse_id,$c_exmine);

        return $rs;
    }


    //管理员审核课程  （0->审核中,1->审核未通过,2->审核通过）
    public function examineCourse($courseId,$con){
        $model=new Model_Course();
        $rs=$model->examineCourse($courseId,$con);
        return $rs;
    }

    //管理员批量审核课程  （0->审核中,1->审核未通过,2->审核通过）
    public function batchExamineCourse($courseNos,$con){
        $model=new Model_Course();
        $model->batchExamineCourse($courseNos,$con);
    }


    //获取选课学生最多的前4课程
    public function selectCourseByPM(){
        $model=new Model_Course();
        $rs=$model->selectCourseByPM();
        return $rs;
    }

    //按课程分类查询
    public function selectCourseByCat(){
        $model=new Model_Course();
        $rs=$model->selectCourseByCat();
        return $rs;
    }
}