<?php
/**
 * Created by PhpStorm.
 * User: xwk
 * Date: 2017/3/14
 * Time: 13:46
 */

class Domain_User{
    //根据用户名查找
    public function getUsersByName($name){
        $rs=array();
        $model=new Model_User();
        $rs=$model->getUsersByName($name);
        return $rs;
    }


    //获取用户列表
    public function getUsersList($name){
        $model=new Model_User();
        $rs=$model->getUsersList($name);
        return $rs;
    }

    //分页获取用户列表
    public function getUsersListPage($name,$page)
    {
        $model=new Model_User();
        $rs=$model->getUsersListPage($name,$page);

        return $rs;

    }


    //注册domain
    public function registerUser($name,$user_pwd,$sex,$role,$email,$tx_url){

        $model=new Model_User();
        $rs=$model->registerUser($name,$user_pwd,$sex,$role,$email,$tx_url);
        if($rs){
            return $rs;
        }
        return $rs;
    }

    //用户登录 （根据pwd和login_name查找role,tx_url,name）
    public function login($name,$pwd){
        $model=new Model_User();
        $rs=$model->login($name,$pwd);
        return $rs;
    }

    //用户上传头像
    public function updateTx($name,$url){
        $model=new Model_User();
        $rs=$model->updateTx($name,$url);
        return $rs;
    }

    //删除用户
    public function delUser($name){
        $model=new Model_User();
        $rs=$model->delUser($name);
       return $rs;
    }
    //批量删除
    public function delUserBatch($names){
        $model=new Model_User();
        $model->delUserBatch($names);
    }

    //修改用户(根据用户id)
    public function updateUser($id,$name,$pwd,$sex,$role,$email){
       $model=new Model_User();
        $rs=$model->updateUser($id,$name,$pwd,$sex,$role,$email);

        return $rs;
    }
}