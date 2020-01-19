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



    /**管理员登陆
     * @return string
     * @throws \Exception
     */
    public function adminLogin(){
        $this -> isLogin();
        return View::fetch('index/login');
    }

    /**后台管理主页
     * @return string
     * @throws \Exception
     */
    public function indexView(){
        return View::fetch('index/index');
    }

    /**后台欢迎页
     * @return string
     * @throws \Exception
     */
    public function indexWelcome(){
        return View::fetch('index/welcome');
    }

    /**添加管理员
     * @return string
     * @throws \Exception
     */
    public function userAdd(){
        return View::fetch('user/add');
    }

    /**在线命令视图
     * @return string
     * @throws \Exception
     */
    public function commandView(){
        return View::fetch('command/command');
    }

    public function add_table_crud(){
        return View::fetch('command/add_table_crud');
    }

    /**
     * 判断是否登陆
     */
    public function isLogin(){
        $user = session(config('admin.session_user'));

        if(!empty($user)){
            return header('location:/admin/adminIndex');
        }
    }
}