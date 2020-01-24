<?php
namespace app\admin\controller;
use app\common\business\lib\BaseMethod;
use think\facade\View;
class AdminAuthGroup extends BaseMethod {

    public function view(){
        return View::fetch('auth/admin_auth_group/admin_auth_group');
    }

    public function viewAddEdit(){
        return View::fetch('auth/admin_auth_group/add_edit');
    }

    public function retrieveData(){
        if(!(request()->isPost())){
            return back_admin_index();
        }
        $key = $this -> request -> param("key", '', 'trim');
        $value = $this -> request -> param("value", '', 'trim');
        return $this -> show(
            config("status.success"),
            config("message.success"),
            $this -> Retrieve('z_admin_auth_group', $key, $value)
        );
    }
    
    public function updateData(){
        if(!(request()->isPost())){
            return back_admin_index();
        }
        $id = $this -> request -> param("target", '', 'trim');
        $data['id'] = $this -> request -> param("id", '', 'trim');
        $data['name'] = $this -> request -> param("name", '', 'trim');
        $data['rules'] = $this -> request -> param("rules", '', 'trim');
        $data['updatetime'] = time();
        $backInfo = $this -> Update('z_admin_auth_group', $id ,$data);
        return $this -> show(
            config("status.success"),
            config("message.success"),
            "更改了".$backInfo."条数据"
        );
    }
    
    public function deleteData(){
        if(!(request()->isPost())){
            return back_admin_index();
        }
        $id = $this -> request -> param("target", '', 'trim');
        return $this -> show(
            config("status.success"),
            config("message.success"),
            $this -> Delete('z_admin_auth_group', $id)
        );
    }
    
    public function createData(){
        if(!(request()->isPost())){
            return back_admin_index();
        }
        $data['name'] = $this -> request -> param("name", '', 'trim');
        $data['rules'] = $this -> request -> param("rules", '', 'trim');
        $data['createtime'] = time();
        $data['updatetime'] = time();
        $backInfo = $this -> Create('z_admin_auth_group', $data);
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
        if(!(request()->isPost())){
            return back_admin_index();
        }
        return $this -> show(
            config("status.success"),
            config("message.success"),
            $this -> throwAll('z_admin_auth_group')
        );
    }
    
    public function batchDeleteData(){
        if(!(request()->isPost())){
            return back_admin_index();
        }
        $ids = $this -> request -> param("ids", '', 'trim');
        return $this -> show(
            config("status.success"),
            config("message.success"),
            $this -> batchDelete('z_admin_auth_group', $ids)
        );
    }

}
        