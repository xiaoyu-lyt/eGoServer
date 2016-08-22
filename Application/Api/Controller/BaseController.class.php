<?php
/**
 * BaseController.class.php
 * Created by PhpStorm.
 * Author: xiaoyu
 * Time: 8/15/16 15:17
 */

namespace Api\Controller;

use Think\Controller\RestController;

load("@.functions");

class BaseController extends RestController
{
    public function checkToken($token) {
        if (!D('User')->checkToken($token)) {
            $this->response(array('error'=>'Token验证失败'), 'json', 401);
        }
    }
}