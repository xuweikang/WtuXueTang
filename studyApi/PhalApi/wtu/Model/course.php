<?php
/**
 * Created by PhpStorm.
 * User: xwk
 * Date: 2017/3/14
 * Time: 15:39
 */
class Model_Course extends PhalApi_Model_NotORM{

    //上传课程
    public function addCourse($name,$c_name,$c_no,$c_start,$c_end,$c_classify,$c_introduce,$c_exmine,$c_img){


        $data = array(
            'c_creator'=>$name,
            'c_name'=>$c_name,
            'c_no'=>$c_no,
            'c_start'=>$c_start,
            'c_end'=>$c_end,
            'c_classify'=>$c_classify,
            'c_introduce'=>$c_introduce,
            'c_exmine'=>$c_exmine,
            'c_img'=>$c_img

        );


        $rs = DI()->notorm->course_configure
            ->insert($data);
        return $rs;
    }
    //上传课程详细章节
    public function addCourseChapter($c_id,$capter_id,$c_content,$capter_introduce,$c_url){

        $rs2 =DI()->notorm->course_capter
            ->where('c_id= ?',$c_id)
            ->delete();

        $data = array(
            'c_id'=>$c_id,
            'capter_id'=>$capter_id,
            'c_content'=>$c_content,
            'capter_introduce'=>$capter_introduce,
            'c_url'=>$c_url

        );
        $rs = DI()->notorm->course_capter
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
    //首页获取课程列表


    //教师查看个人课程列表
    public function getCourseListTeacher($name){
        return DI()->notorm->course_configure
            ->select('*')
            ->where('c_creator= ?' ,$name)
            ->fetchRows();
    }

    //修改课程(根据课程id)
    public function updateCourse($course_id,$c_name,$c_no,$c_introduce,$c_classify,$c_start,$c_end){
        $data = array(
            'c_name' => $c_name,
            'c_no' => $c_no,
            'c_introduce' => $c_introduce,
            'c_classify'=>$c_classify,
            'c_start' => $c_start,
            'c_end' => $c_end

        );
        $rs =DI()->notorm->course_configure
            ->where('c_no = ?',$course_id)
            ->update($data);
        return $rs;
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
            return 'delete error';
        }
    }
    //删除课程章节
    public function removeCourseCapter($course_id){
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
            return 'delete error';
        }
    }

    //查看课程详细
    public function selectCourseDetail($course_id){
        $sql="select  kc.*  ,sp.* from course_configure kc  , course_capter sp where kc.c_no=sp.c_id AND kc.c_no='{$course_id}' ORDER BY capter_id";

        $rs=$this->getORM()->queryAll($sql,array());

        return $rs;
    }
    //只查看课程章节表信息
    public function getCourseChapter($course_id){
//            $rs=DI()->notorm->course_capter
//                ->select('*')
//                ->where('c_id= ? ',$course_id)
//                ->fetchRows();
        $sql="select * from course_capter  where c_id = '{$course_id}' ORDER BY capter_id;";

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




    //获取选课学生最多的前4课程


    public function selectCourseByPM($isLimit){
        if($isLimit==1){
            $sql="select * from (

SELECT
	*
FROM
	course_configure where c_exmine=2 )table1
INNER JOIN (
	SELECT
		count(*) AS num,
		course
	FROM
		student_course
	GROUP BY
		course
) table2 ON table1.c_no = table2.course
GROUP BY
	course
ORDER BY
	num DESC
LIMIT 0,
 4 ";
        }else{
            $sql="select * from (

SELECT
	*
FROM
	course_configure where c_exmine=2 )table1
INNER JOIN (
	SELECT
		count(*) AS num,
		course
	FROM
		student_course
	GROUP BY
		course
) table2 ON table1.c_no = table2.course
GROUP BY
	course
ORDER BY
	num DESC ";
        }

        $rs=$this->getORM()->queryAll($sql,array());

        return $rs;
    }

    public function selectCourseByPMId($c_id){

        $rs1=DI()->notorm->student_course
            ->select('*')
            ->where('course= ? ',$c_id)
            ->fetchRows();
        if($rs1){
            $sql="select * from (

SELECT
	*
FROM
	course_configure where c_exmine=2 AND c_no='{$c_id}' )table1
INNER JOIN (
	SELECT
		count(*) AS num,
		course
	FROM
		student_course
	GROUP BY
		course
) table2 ON table1.c_no = table2.course";
        }else{
            $sql="SELECT * FROM course_configure where c_exmine=2 and c_no='{$c_id}'";
        }


;

        $rs=$this->getORM()->queryAll($sql,array());

        return $rs;
    }



    //按课程分类查询
    public function selectCourseByCat(){
        $sql="SELECT c_start, c_classify,COUNT(c_classify) AS num FROM course_configure GROUP BY c_classify";

        $rs=$this->getORM()->queryAll($sql,array());

        return $rs;
    }

    //学生选课
    public function addStudentCourse($name,$course,$score,$isfill){
        $data = array(
            'name'=>$name,
            'course'=>$course,
            'xiti_score'=>$score,
            'isFill'=>$isfill
        );
        $rs = DI()->notorm->student_course
            ->insert($data);
        return $rs;
    }

    //获得选课学生信息
    public function selectCourseByCourse($c_id){
        $sql="select * from user_identity a INNER JOIN (select * from student_course where course = '{$c_id}') b on a.name = b.name";

        $rs=$this->getORM()->queryAll($sql,array());

        return $rs;
    }

    //修改练习题分数
    public function markScore($name,$course,$score,$isFill){

        $data=array(
            'xiti_score'=>$score,
            'isFill'=>$isFill
        );
        $rs =DI()->notorm->student_course
            ->where('name = ?',$name)
            ->where('course = ?',$course)
            ->update($data);
        return $rs;
    }
    //
    public function selScore($name,$course){

        $rs=DI()->notorm->student_course
            ->select('*')
            ->where('name = ?',$name)
            ->where('course = ?',$course)
            ->fetchRows();
        return $rs;
    }

    //模糊搜索查询课程
    public function searchCourse($key){

        $sql="SELECT * FROM course_configure WHERE c_name LIKE '%{$key}%' AND c_exmine='2' ";

        $rs=$this->getORM()->queryAll($sql,array());

        return $rs;
    }

    //查询首页显示的课程
    public function findCourse(){

        $sql="select a.* from (select course_configure.* from course_configure where c_exmine ) a INNER JOIN course_capter ON a.c_no = course_capter.c_id  GROUP BY a.c_no";

        $rs=$this->getORM()->queryAll($sql,array());

        return $rs;
    }


    //学生查看选择课程
    public function findCourseSelected($name){

        $sql="select * from course_configure a  INNER JOIN (select * from student_course where name = '{$name}') b on a.c_no = b.course;";

        $rs=$this->getORM()->queryAll($sql,array());

        return $rs;
    }


}