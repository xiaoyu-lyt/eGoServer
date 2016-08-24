<?php
/**
 * UserModel.class.php
 * Created by PhpStorm.
 * Author: xiaoyu
 * Time: 8/15/16 16:07
 */

namespace Api\Model;

use Api\Model\BaseModel;

class UserModel extends BaseModel
{
    /**
     * 判断手机号是否已经注册,已注册返回true,未注册返回false
     * @access public
     *
     * @param string $tel 手机号
     *
     * @return bool
     */
    public function isExisted($tel) {
        $user = M('User')->where("tel = '{$tel}'")->find();
        if (!$user) {
            return false;
        }
        return true;
    }
    
    /**
     * 注册新用户,注册成功返回新用户token,失败返回null
     * @access public
     *
     * @param string $tel      新用户手机号
     * @param string $password 新用户密码
     *
     * @return null|string
     */
    public function register($tel, $password) {
        $data['tel'] = $tel;
        $data['salt'] = create_random_string(8);
        $data['hash'] = md5(hash('sha256', $password) . $data['salt']);
        $data['token'] = create_token($tel);
        
        $id = M('User')->data($data)->add();
        if (!$id) {
            return null;
        }
        return $data['token'];
    }
    
    /**
     * 登录检验,登录成功返回token,用户不存在返回0,密码错误返回1,token更新失败返回2
     * @access public
     *
     * @param string $tel      用户手机号
     * @param string $password 用户密码
     *
     * @return int|string
     */
    public function checkLogin($tel, $password) {
        $salt = M('User')->where("tel = '{$tel}'")->getField('salt');
        $hash = M('User')->where("tel = '{$tel}'")->getField('hash');
        
        if (!$hash) {
            return 0;
        } elseif (md5(hash('sha256', $password) . $salt) != $hash) {
            return 1;
        }
        
        $data['token'] = create_token($tel);
        $id = M('User')->where("tel = '{$tel}'")->save($data);
        if (!$id) {
            return 2;
        }
        return $data['token'];
    }
    
    /**
     * 检验用户token是否正确,正确返回true,错误返回false
     * @access public
     *
     * @param string $token 用户token
     *
     * @return bool
     */
    public function checkToken($token) {
        $user = M('User')->where("token = '{$token}'")->find();
        if (!$user) {
            return false;
        }
        return true;
    }
    
    /**
     * 获取用户信息,获取成功返回用户信息(数组),失败返回null
     * @access public
     *
     * @param string $tel 用户手机号
     *
     * @return mixed|null
     */
    public function getUserInfo($tel) {
        $user = M('User')->where("tel = '{$tel}'")->field('name, gender, tel, nickname, signature, avatar, school, college, major, stu_num')->find();
        if (!$user) {
            return null;
        }
        return $user;
    }
    
    /**
     * 更新用户信息
     * @access public
     *
     * @param string $token 用户令牌
     * @param array  $data  要更新的用户信息数组
     *
     * @return bool
     */
    public function updateUserInfo($token, $data) {
        if ($data['password'] != null) {
            $salt = M('User')->where("token = '{$token}'")->getField('salt');
            $data['hash'] = md5(hash('sha256', $data['password']) . $salt);
        }
        $id = M('User')->where("token = '{$token}'")->save($data);
        if (!$id) {
            return false;
        }
        return true;
    }
    
    /**
     * 学生通过身份验证后更新学生信息,更新成功返回true,失败返回false
     * @access public
     *
     * @param string $token 学生用户token
     * @param array  $data  学生信息数组
     *
     * @return bool
     */
    public function updateStudentInfo($token, $data) {
        $id = M('User')->where("token = '{$token}'")->save($data);
        if (!$id) {
            return false;
        }
        return true;
    }
}