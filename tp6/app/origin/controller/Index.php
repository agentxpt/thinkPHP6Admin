<?php
/**
 *
 *
 * @description:  我起了，一枪秒了，有什么好说的XD
 * @author: shenzheng
 * @time: 2019/12/26 上午10:03
 *
 */
namespace app\origin\controller;
use app\BaseController;
use think\facade\App;
use think\facade\Db;
use app\common\business\Article;

class Index extends BaseController{

    public function index(){

        echo App::getAppPath();
    }
	
	
	
	
}