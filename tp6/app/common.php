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