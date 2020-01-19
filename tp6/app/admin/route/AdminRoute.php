<?php
use think\facade\Route;

Route::rule('adminIndex', 'AdminView/indexView', 'GET');
Route::rule('login', 'AdminView/adminLogin', 'GET');