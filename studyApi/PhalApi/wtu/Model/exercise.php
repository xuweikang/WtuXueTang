<?php

/**
 * Created by PhpStorm.
 * User: xwk
 * Date: 2017/3/30
 * Time: 17:35
 */
class Model_Exercise extends PhalApi_Model_NotORM
{

    //获得练习题信息
    public function getExercise($c_id)
    {
        if ($c_id) {
            return DI()->notorm->exercises
                ->select('*')
                ->where('c_id= ?', $c_id)
                ->order('id asc')
                ->fetchRows();
        } else {
            return DI()->notorm->exercises
                ->select('*')
                ->fetchRows();
        }
    }

    //删除练习题
    public function delExercise($id)
    {
        return DI()->notorm->exercises
            ->where('id= ?', $id)
            ->delete();

    }

    //批量删除练习题
    public function batchDelExercise($ids)
    {
        $idsArr = explode(',', $ids);
        for ($index = 0; $index < count($idsArr); $index++) {
            $rs = DI()->notorm->exercises
                ->where('id = ?', $idsArr[$index])
                ->delete();
        }
    }

    //修改练习题
    public function updateExercise($id, $c_id, $content, $right_option, $option_1, $option_2, $option_3, $score)
    {

        $data = array(
            'content' => $content,
            'c_id' => $c_id,
            'right_option' => $right_option,
            'option_1' => $option_1,
            'option_2' => $option_2,
            'option_3' => $option_3,
            'score' => $score
        );
        $rs = DI()->notorm->exercises
            ->where('id = ?', $id)
            ->update($data);
        return $rs;
    }

    //上传练习题
    public function addExercise($c_id,$content,$right_opt,$opt1,$opt2,$opt3,$score){
        $data = array(
            'c_id'=>$c_id,
            'content'=>$content,
            'right_option'=>$right_opt,
            'option_1'=>$opt1,
            'option_2'=>$opt2,
            'option_3'=>$opt3,
            'score'=>$score
        );
        $rs = DI()->notorm->exercises
            ->insert($data);
        return $rs;
    }






}