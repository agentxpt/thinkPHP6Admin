<?php
namespace app\origin\controller;

class Error
{
    public function __call($name, $arguments)
    {
        return show_error(config("status.error"), "找不到{$name}控制器", config("message.error"), 0);
    }
}
