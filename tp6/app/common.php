<?php
// 应用公共文件

function show_res($status, $message, $data, $HttpStatus = 200){
    $result = [
        'status' => $status,
        'message' => $message,
        'result' => $data
    ];
    return json($result, $HttpStatus);
}

function show_error($status, $message = '错误', $data, $HttpStatus = 200){
    $result = [
        'status' => $status,
        'message' => $message,
        'result' => $data
    ];
    return json($result, $HttpStatus);
}

function back_admin_login(){
    return redirect('/admin/login');
}

function back_admin_index(){
    return redirect('/admin/Index');
}

function back_error(){
    return redirect('/admin/AdminBaseAccess/errorView');
}