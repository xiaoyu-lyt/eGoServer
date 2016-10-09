<?php
/**
 * ChatCenterController.class.php
 * Created by PhpStorm.
 * Author: xiaoyu
 * Time: 01/10/2016 20:23
 */

namespace Api\Controller;

use  Api\Controller\BaseController;

class ChatCenterController extends BaseController
{
    public function getAllChat_get() {
        $data = D('ChatCenter')->getAllChat();
        $this->response($data, 'json', 200);
    }
    
    public function getComments_get($id) {
        $data = D('ChatCenter')->getCommentsWithId($id);
        $this->response($data, 'json', 200);
    }
    
    public function like_post() {
        $token = I('post.token');
        $chatId = I('post.chatId');
        $this->checkToken($token);
        
        $userInfo = M('User')->where("token = '{$token}'")->find();
        $userId = $userInfo['stu_num'];
        
        $result = D('ChatCenter')->like($chatId, $userId);
        if (!$result) {
            $this->response(array('error' => '操作失败'), 'json', 400);
        }
        $this->response(array('msg' => '操作成功'), 'json', 201);
    }
    
    public function unlike_post() {
        $token = I('post.token');
        $chatId = I('post.chatId');
        $this->checkToken($token);
        
        $userInfo = M('User')->where("token = '{$token}'")->find();
        $userId = $userInfo['stu_num'];
        
        $result = D('ChatCenter')->unlike($chatId, $userId);
        if (!$result) {
            $this->response(array('error' => '操作失败'), 'json', 400);
        }
        $this->response(array('msg' => '操作成功'), 'json', 201);
    }
}