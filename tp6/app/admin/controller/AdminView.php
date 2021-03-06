<?php
/**
 *
 *
 * @description:  我起了，一枪秒了，有什么好说的XD
 * @author: shenzheng
 * @time: 2020/1/12 下午9:17
 *
 */


namespace app\admin\controller;


use app\BaseController;
use think\facade\View;

class AdminView extends BaseController {


    public function userAdd(){
        return View::fetch('user/add');
    }

    public function commandView(){
        return View::fetch('command/command');
    }

    public function add_table_crud(){
        return View::fetch('command/add_table_crud');
    }

    public function catalogueView(){
        return View::fetch('catalogue/catalogue');
    }

    public function catalogueAddEdit(){
        return View::fetch('catalogue/add_edit');
    }



}