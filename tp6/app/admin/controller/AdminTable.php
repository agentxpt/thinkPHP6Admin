<?php
/**
 *
 *
 * @description:  我起了，一枪秒了，有什么好说的XD
 * @author: shenzheng
 * @time: 2020/1/17 上午9:55
 *
 */


namespace app\admin\controller;
use app\BaseController;
use app\common\business\admin\AdminTable as AdminTableBusiness;


class AdminTable extends BaseController {

    public function getAllTable(){
        if(!(request()->isPost())){
            return redirect('/admin/adminIndex');
        }
        $adminTableBusiness = new AdminTableBusiness();
        return $this -> show(
            config("status.success"),
            config("message.success"),
            $adminTableBusiness -> getAllTables()
        );

    }

    public function codeGenerator(){

        if(!(request()->isPost())){
//            return redirect('/admin/adminIndex');
        }
        $tableName = $this -> request -> param("tableName", '', 'trim');

        if($tableName == NULL){
            return $this -> show(
                config("status.error"),
                config("message.no_key"),
                NULL
            );
        }
        $adminTableBusiness = new AdminTableBusiness();
        $isSuccessController = $adminTableBusiness -> generateController($tableName);
        $isSuccessView = $adminTableBusiness -> generateView($tableName);
        $isSuccessJS = $adminTableBusiness -> generateJS($tableName);

        return $this -> show(
            config("status.success"),
            config("message.success"),
            NULL
        );
    }


}