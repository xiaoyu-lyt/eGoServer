<?php
/**
 * UserController.class.php
 * Created by PhpStorm.
 * Author: xiaoyu
 * Time: 8/15/16 15:38
 */

namespace Api\Controller;

use Api\Controller\BaseController;

class UserController extends BaseController
{
    /**
     * 获取手机验证码,成功返回验证码,失败返回错误信息
     * @access public
     *
     * @param $tel
     */
    public function verifyCode_get($tel) {
        if (D('User')->isExisted($tel)) {
            $this->response(array('error' => '该手机号已注册'), 'json', 200);
        }
        
        $verifyCode = send_verify_code($tel);
        if ($verifyCode === 0) {
            $this->response(array('error' => '验证码发送失败'), 'json', 200);
        }
        $this->response(array('verifyCode' => $verifyCode), 'json', 200);
    }
    
    /**
     * 注册新用户,注册成功返回新用户token,失败返回错误信息
     * @access public
     */
    public function register_post() {
        $tel = I('post.tel');
        $password = I('post.password');
        
        $token = D('User')->register($tel, $password);
        if (!$token) {
            $this->response(array('error' => '注册失败'), 'json', 400);
        }
        $this->response(array('token' => $token), 'json', 201);
    }
}