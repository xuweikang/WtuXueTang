<?php
/**
 * Created by PhpStorm.
 * User: xwk
 * Date: 2017/3/14
 * Time: 13:46
 */

class Model_User extends PhalApi_Model_NotORM
{
    //根据用户名查找
    public function getUsersByName($name){
        return DI()->notorm->user_identity
            ->select('*')
            ->where('name = ?', $name)
            ->fetch();
    }

    //获取用户列表
    public function getUsersList($name)
    {
      if($name){
          return DI()->notorm->user_identity
              ->select('*')
              ->where('name= ?' , $name)
              ->fetchRows();
      }else{
          return DI()->notorm->user_identity
              ->select('*')
              ->fetchRows();
      }
    }

    //分页获取用户列表
    public function getUsersListPage($name,$page)
    {
        if($name){
            return DI()->notorm->user_identity
                ->select('*')
                ->where('name = ?',$name)
                ->fetchRows();
        }else{
            return DI()->notorm->user_identity
                ->select('*')
                ->limit(($page-1)*10,10)
                ->fetchRows();
        }

    }

    //注册添加用户
    public function registerUser($name,$user_pwd,$sex,$role,$email,$tx_url){
        $data = array(
            'name'=>$name,
            'user_pwd'=>$user_pwd,
            'sex'=>$sex,
            'role'=>$role,
            'email'=>$email,
            'tx_url'=>$tx_url

        );
        $rs = DI()->notorm->user_identity
            ->insert($data);
        return $rs;
    }

    //用户登录 （根据pwd和login_name查找role,tx_url,name）
    public function login($name,$pwd){
        $rs=DI()->notorm->user_identity
            ->select('role,tx_url,name')
            ->where('name = ?',$name)
            ->where('user_pwd = ?',$pwd)
            ->fetch()
        ;

            return $rs;
    }


    //用户上传头像
    public function updateTx($name,$url){
        $data = array(
            'tx_url'=>$url
        );
        $rs=DI()->notorm->user_identity
            ->where('name = ?',$name)
            ->update($data)
        ;

        return $rs;
    }

    //删除用户
    public function delUser($name){
        $rs =DI()->notorm->user_identity
            ->where('name = ?',$name)
            ->delete();
        if($rs==false){
            throw new PhalApi_Exception_BadRequest('删除数据失败');
        }
        return $rs;
    }
    //批量删除
    public function delUserBatch($names){
        $nameArr = explode(',',$names);
        for($index=0;$index<count($nameArr);$index++){
            $rs =DI()->notorm->user_identity
                ->where('name = ?',$nameArr[$index])
                ->delete();
        }
    }
    //修改用户(根据用户id)
    public function updateUser($id,$name,$pwd,$sex,$role,$email){
        $data = array(
            'name' => $name,
            'user_pwd' => $pwd,
            'sex' => $sex,
            'role' => $role,
            'email' => $email

        );
        $rs =DI()->notorm->user_identity
            ->where('id = ?',$id)
            ->update($data);
        return $rs;
    }


}