<?php
/**
 * Created by PhpStorm.
 * User: xwk
 * Date: 2017/3/14
 * Time: 15:44
 */
class Domain_Course{
    //上传课程
    public function addCourse($name,$c_name,$c_no,$c_start,$c_end,$c_classify,$c_introduce,$c_exmine,$c_img){

        $model=new Model_Course();
        $rs=$model->addCourse($name,$c_name,$c_no,$c_start,$c_end,$c_classify,$c_introduce,$c_exmine,$c_img);
        return $rs;
    }

    //上传课程详细章节
    public function addCourseChapter($c_id,$capter_id,$c_content,$capter_introduce,$c_url){
      $model=new Model_Course();
        return $model->addCourseChapter($c_id,$capter_id,$c_content,$capter_introduce,$c_url);
    }

    //获得所有课程列表
    public function getCoursesList($course_id)
    {
        $model=new Model_Course();
        $rs=$model->getCoursesList($course_id);

        return $rs;
    }
    //教师查看个人课程列表
    public function getCourseListTeacher($name){
        $model=new Model_Course();
        return $model->getCourseListTeacher($name);
    }
    //修改课程(根据课程id)
    public function updateCourse($course_id,$c_name,$c_no,$c_introduce,$c_classify,$c_start,$c_end){
        $model=new Model_Course();

        return $model->updateCourse($course_id,$c_name,$c_no,$c_introduce,$c_classify,$c_start,$c_end);
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

    //只查看课程章节表信息
    public function getCourseChapter($course_id){
        $model=new Model_Course();
        $rs=$model->getCourseChapter($course_id);

        return $rs;

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
    public function selectCourseByPM($isLimit){
        $model=new Model_Course();
        $rs=$model->selectCourseByPM($isLimit);
        return $rs;
    }
    public function selectCourseByPMId($c_id){

        $model=new Model_Course();
        $rs=$model->selectCourseByPMId($c_id);
        return $rs;
    }

    //按课程分类查询
    public function selectCourseByCat(){
        $model=new Model_Course();
        $rs=$model->selectCourseByCat();
        return $rs;
    }

    //学生选课
    public function addStudentCourse($name,$course,$score,$isfill){
        $model=new Model_Course();
        $rs=$model->addStudentCourse($name,$course,$score,$isfill);
        return $rs;
    }

    //获得选课学生信息
    public function selectCourseByCourse($c_id){

        $model=new Model_Course();
        $rs=$model->selectCourseByCourse($c_id);
        return $rs;
    }

    //修改练习题分数
    public function markScore($name,$course,$score,$isFill){

        $model=new Model_Course();
        $rs=$model->markScore($name,$course,$score,$isFill);
        return $rs;
    }

    public function selScore($name,$course){

        $model=new Model_Course();
        $rs=$model->selScore($name,$course);
        return $rs;
    }

    //模糊搜索查询课程
    public function searchCourse($key){

        $model=new Model_Course();
        $rs=$model->searchCourse($key);
        return $rs;
    }
    //查询首页显示的课程
    public function findCourse(){

        $model=new Model_Course();
        $rs=$model->findCourse();
        return $rs;
    }

    //学生查看选择课程
    public function findCourseSelected($name){

        $model=new Model_Course();
        $rs=$model->findCourseSelected($name);
        return $rs;
    }
}