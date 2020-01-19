<?php
namespace app\admin\controller;
use app\common\business\lib\BaseMethod;
use think\facade\View;
class Test extends BaseMethod {

    public function view(){
        return View::fetch('generate/test/test');
    }

    public function viewAddEdit(){
        return View::fetch('generate/test/add_edit');
    }

    public function retrieveData(){
        $key = $this -> request -> param("key", '', 'trim');
        $value = $this -> request -> param("value", '', 'trim');
        return $this -> show(
            config("status.success"),
            config("message.success"),
            $this -> Retrieve('test', $key, $value)
        );
    }
    
    public function updateData(){
        $id = $this -> request -> param("target", '', 'trim');
        $data = $this -> request -> param(['id','aaa','bbb']);
        $backInfo = $this -> Update('test', $id ,$data);
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
            $this -> Delete('test', $id)
        );
    }
    
    public function createData(){
        $data = $this -> request -> param();
        $backInfo = $this -> Create('test', $data);
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
            $this -> throwAll('test')
        );
    }
    
    public function batchDeleteData(){
        $ids = $this -> request -> param();
        return $this -> show(
            config("status.success"),
            config("message.success"),
            $this -> batchDelete('test', $ids)
        );
    }

}
        