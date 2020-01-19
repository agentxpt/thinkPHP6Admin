<?php
/**
 *
 *
 * @description:  我起了，一枪秒了，有什么好说的XD
 * @author: shenzheng
 * @time: 2020/1/12 下午8:24
 *
 */


namespace app\admin\controller;


use app\BaseController;
use think\exception\ValidateException;
use app\common\validate\admin\AdminLogin;
use app\common\business\admin\AdminUser as AdminUserBusiness;
use app\common\validate\admin\AdminUser as AdminUserValidate;


class AdminUser extends BaseController {

    public function adminQuit(){
//        halt(session(config('admin.session_user')));
        session(NULL, config('admin.session_user_scope'));
        return redirect('/admin/login');
    }

    /**管理员登陆
     * @return string|\think\response\Json
     * @throws \Exception
     *
     */
    public function adminLogin(){

        if(!(request()->isPost())){
            return redirect('/admin/login');
        }
        $data["username"] = $this -> request -> param("username", '', 'trim');
        $data["password"] = $this -> request -> param("password", '', 'trim');
        $data["validate"] = $this -> request -> param("validate", '', 'trim');

        try{
            validate(AdminLogin::class) -> check($data);
        }catch (ValidateException $exception){

            $judge = $exception -> getMessage();
            //为空或验证码错误
            return $this -> show(
                config("status.error"),
                config("message.error"),
                $judge
            );
        }
        $adminUserBusiness = new AdminUserBusiness();
        $result = $adminUserBusiness -> adminLogin($data);

        if($result == NULL){
            //用户不存在
            return $this -> show(
                config("status.error"),
                config("message.error"),
                config("message.user_not_exist")
            );
        }else if($result == config("status.failed")){
            //密码错误
            return $this -> show(
                config("status.error"),
                config("message.failed"),
                config("message.password_fault")
            );
        }else if($result == config("status.success")){
            //登陆成功
            return $this -> show(
                config("status.success"),
                config("message.success"),
                $result
            );
        }


    }

    /**添加管理员
     * @return string|\think\response\Json
     * @throws \Exception
     */
    public function addAdminUser(){

        if(!(request()->isPost())){
            return redirect('/admin/adminIndex');
        }
        //数据获取
        $data["username"] = $this -> request -> param("username", '', 'trim');
        $data["password"] = $this -> request -> param("password", '', 'trim');
        $validate = validate(AdminUserValidate::class);

        if(!$validate -> check($data)){

            return $this -> show(
                config("status.error"),
                config("message.no_key"),
                NULL
            );
        }
        $adminUserBusiness = new AdminUserBusiness();
        $data = $adminUserBusiness -> passwordAddSalt($data);
        $res = $adminUserBusiness -> add($data);

        if($res == "用户名重复"){

            return $this -> show(
                config("status.failed"),
                config("message.name_multiple"),
                $res
            );
        }

        return $this -> show(
            config("status.success"),
            config("message.success"),
            $res
        );

    }

}