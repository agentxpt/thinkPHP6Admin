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
use app\common\business\admin\AdminUser as AdminUserBusiness;
use app\common\validate\admin\AdminUser as AdminUserValidate;


class AdminUser extends BaseController {




    /**添加管理员
     * @return string|\think\response\Json
     * @throws \Exception
     */
    public function addAdminUser(){

        if(!(request()->isPost())){
            return back_admin_index();
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