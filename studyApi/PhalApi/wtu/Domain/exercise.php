<?php

/**
 * Created by PhpStorm.
 * User: xwk
 * Date: 2017/3/31
 * Time: 11:46
 */
class Domain_Exercise
{

    //获得练习题信息
    public function getExercise($c_id)
    {
        $model = new Model_Exercise();
        return $model->getExercise($c_id);
    }


    //删除练习题
    public function delExercise($id)
    {
        $model = new Model_Exercise();
        return $model->delExercise($id);


    }

    //批量删除练习题
    public function batchDelExercise($ids)
    {
        $model = new Model_Exercise();
        $model->batchDelExercise($ids);
    }

    //修改练习题
    public function updateExercise($id, $c_id, $content, $right_option, $option_1, $option_2, $option_3, $score)
    {

        $model = new Model_Exercise();
        return $model->updateExercise($id, $c_id, $content, $right_option, $option_1, $option_2, $option_3, $score);
    }
    //上传练习题
    public function addExercise($c_id,$content,$right_opt,$opt1,$opt2,$opt3,$score){
        $model=new Model_Exercise();
        return $model->addExercise($c_id,$content,$right_opt,$opt1,$opt2,$opt3,$score);
    }
}