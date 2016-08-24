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
    public function getVerifyCode_get($tel) {
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
        
        if (D('User')->isExisted($tel)) {
            $this->response(array('error' => '该手机号已注册'), 'json', 400);
        }
        
        $token = D('User')->register($tel, $password);
        if (!$token) {
            $this->response(array('error' => '注册失败'), 'json', 400);
        }
        $this->response(array('token' => $token), 'json', 201);
    }
    
    /**
     * 用户登录检验,登录成功返回新token,失败返回错误信息
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
                $this->response(array('error' => 'token更新失败'), 'json', 500);
                break;
            default:
                $this->response(array('token' => $result), 'json', 201);
                break;
        }
    }
    
    /**
     * 获取用户信息,成功返回用户信息,失败返回错误信息
     * @access public
     *
     * @param string $token 当前用户令牌
     * @param string $tel   要查询的用户的手机号
     */
    public function getUserInfo_get($token, $tel) {
        $this->checkToken($token);
        
        $user = D('User')->getUserInfo($tel);
        if (!$user) {
            $this->response(array('error' => '用户不存在'), 'json', 404);
        }
        $this->response($user, 'json', 200);
    }
    
    /**
     * 更新用户信息,成功不返回数据,失败返回错误信息
     * @access public
     */
    public function modifyUserInfo_put() {
        $data = I('put.');
        $this->checkToken($data['token']);
        
        $updateResult = D('User')->updateUserInfo($data['token'], $data);
        if (!$updateResult) {
            $this->response(array('error' => '信息更新失败'), 'json', 500);
        }
        $this->response(null, 'json', 204);
    }
    
    /**
     * 学生身份验证,成功返回认证成功,失败返回错误信息
     * @access public
     *
     * @param string $token        学生用户token
     * @param string $jwchId       教务处学号
     * @param string $jwchPassword 教务处密码
     */
    public function studentVerify_post() {
        $token = I('post.token');
        $jwchId = I('post.jwchId');
        $jwchPassword = I('post.jwchPassword');
        $this->checkToken($token);
        
        // 模拟登录前的准备，设置URL，POST数据以及cookie文件夹
        $cookie_file = tempnam('./temp', 'cookie');
        $id = $this->checkFromJwch($jwchId, $jwchPassword, $cookie_file);
        if (!$id) {
            $this->response(array('error' => '学号或密码错误'), 'json', 400);
        }
        
        $stuInfo = $this->getInfoFromJwch($id, $cookie_file);
        $stuInfo['stu_num'] = $jwchId;
        $updateResult = D('User')->updateStudentInfo($token, $stuInfo);
        if (!$updateResult) {
            $this->response(array('error' => '信息更新失败'), 'json', 500);
        }
        $this->response(array('msg' => '认证成功'), 'json', 201);
    }
    
    /**
     * 模拟登录教务处验证学生身份,成功返回true,失败返回false
     * @access private
     *
     * @param string $muser       教务处学号
     * @param string $passwd      教务处密码
     * @param string $cookie_file 用于保存cookie的文件名
     *
     * @return bool
     */
    private function checkFromJwch($muser, $passwd, $cookie_file) {
        $url = "http://59.77.226.32/logincheck.asp";
        $post_fields = "muser=" . $muser . "&passwd=" . $passwd . "&x=0&y=0"; // 不要问我为什么,学长说福大教务处就是要这么设置
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_REFERER, "http://jwch.fzu.edu.cn/Index.htm");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $con = curl_exec($ch);
        $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
        
        // 判断是否登录成功
        if (preg_match('/alert/', $con)) {
            return false;
        } else {
            preg_match('/id=(.*)/', $url, $idArr);
            
            return $idArr[1];
        }
    }
    
    /**
     * 从教务处获取学生信息,返回学生信息
     * @access private
     *
     * @param string $id          模拟登录成功后教务处返回的id串
     * @param string $cookie_file 保存cookie的文件名
     *
     * @return array
     */
    private function getInfoFromJwch($id, $cookie_file) {
        $url = "http://59.77.226.35/jcxx/xsxx/StudentInformation.aspx?id=$id";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        $output = curl_exec($ch);
        curl_close($ch);
        preg_match_all('/<span(.*)>(.*)<\/span>/', $output, $infoArr);
        
        return array(
            'name' => $infoArr[2][2],
            'gender' => ($infoArr[2][6] == '男') ? 1 : 0,
            'school' => '福州大学',
            'college' => $infoArr[2][25],
            'major' => $infoArr[2][26],
        );
    }
}