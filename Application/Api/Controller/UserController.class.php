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
            $this->response(array('error' => '验证码发送失败'), 'json', 500);
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
    
    /**
     * 用户登录检验,登录成功返回新token,用户不存在返回0,账号或密码错误返回1,token更新失败返回2
     * @access public
     */
    public function login_post() {
        $tel = I('post.tel');
        $password = I('post.password');
        
        $result = D('User')->checkLogin($tel, $password);
        switch ($result) {
            case '0':
                $this->response(array('error' => '用户不存在'), 'json', 404);
                break;
            case '1':
                $this->response(array('error' => '账号或密码错误'), 'json', 400);
                break;
            case '2':
                $this->response(array('error' => 'token更新失败'), 'json', 400);
                break;
            default:
                $this->response(array('token' => $result), 'json', 201);
                break;
        }
    }
}