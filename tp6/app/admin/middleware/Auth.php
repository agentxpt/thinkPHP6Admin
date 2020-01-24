<?php
declare (strict_types = 1);

namespace app\admin\middleware;

use think\db\exception\DbException;
use think\facade\Db;


class Auth{


    public function handle($request, \Closure $next){

        $user = session(config('admin.session_user'));
        if($user == NULL){
            return $next($request);
        }
        try {
            $auth = Db::table('z_admin_auth_access')->where('username', $user)->find();
            if($auth == NULL){
                return back_error();
            }
            $available = Db::table('z_admin_auth_group')->where('id', $auth['group'])->find();

        }catch (DbException $exception){
            return $this -> show(
                config("status.success"),
                config("message.success"),
                $exception -> getMessage()
            );
        }


        if($available['rules'] == '*'){
            return $next($request);
        }
        $rules = explode(',',$available['rules']);
        $controllers = [];$tableNames = [];$i = 1;
        foreach($rules as $key){
            if($key == NULL){
                continue;
            }
            $controllers[$key] = Db::table('z_admin_generator')->where('id', $key)->find();
        }
        foreach($controllers as $key){
            $tableNames[$i] = str_replace("_","",$key['table_name']);
            $tableNames[$i] = ucwords($tableNames[$i]);
            $i++;
        }

        foreach($tableNames as $key){
            if(preg_match("/$key/", $request -> pathinfo())){
                return $next($request);
            }

        }

        return back_error();
    }

}