<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //重定向到指定的URL地址
        redirect('http://114.215.122.118/show-doc/index.php?s=/1', 0);
    }
}