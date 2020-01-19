<?php
namespace app\admin\controller;
use app\common\business\lib\BaseMethod;
use think\facade\View;
class Zadminuser extends BaseMethod {

    public function view(){
        return View::fetch('generate/zadminuser/zadminuser');
    }

    public function viewAddEdit(){
        return View::fetch('generate/zadminuser/add_edit');
    }

    public function retrieveData(){
        $key = $this -> request -> param("key", '', 'trim');
        $value = $this -> request -> param("value", '', 'trim');
        return $this -> show(
            config("status.success"),
            config("message.success"),
            $this -> Retrieve('z_admin_user', $key, $value)
        );
    }
    
    public function updateData(){
        $id = $this -> request -> param("target", '', 'trim');
        $data = $this -> request -> param(['id','username','password','password_salt','last_login_ip','last_login_time','create_time','update_time']);
        $backInfo = $this -> Update('z_admin_user', $id ,$data);
        return $this -> show(
            config("status.success"),
            config("message.success"),
            "更改了".$backInfo."条数据"
        );
    }
    
    public function deleteData(){
        $id = $this -> request -> param("target", '', 'trim');
        return $this -> show(
            config("status.success"),
            config("message.success"),
            $this -> Delete('z_admin_user', $id)
        );
    }
    
    public function createData(){
        $data = $this -> request -> param();
        $backInfo = $this -> Create('z_admin_user', $data);
        if($backInfo == 1){
            return $this -> show(
                config("status.success"),
                config("message.success"),
                NULL
            );
        }
        return $this -> show(
            config("status.failed"),
            config("message.failed"),
            $backInfo
        );
    }
    
    public function seeAll(){
        return $this -> show(
            config("status.success"),
            config("message.success"),
            $this -> throwAll('z_admin_user')
        );
    }
    
    public function batchDeleteData(){
        $ids = $this -> request -> param();
        return $this -> show(
            config("status.success"),
            config("message.success"),
            $this -> batchDelete('z_admin_user', $ids)
        );
    }

}
        