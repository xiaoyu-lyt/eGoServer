<?php
/**
 * ChatCenterModel.class.php
 * Created by PhpStorm.
 * Author: xiaoyu
 * Time: 01/10/2016 20:39
 */

namespace Api\Model;

use Api\Model\BaseModel;

class ChatCenterModel extends BaseModel
{
    public function getAllChat() {
        $data = M('Chat_center')->order("time desc")->select();
        foreach ($data as &$chat) {
            $userId = $chat['user_id'];
            $userInfo = M('User')->where("id = {$userId}")->field("name, gender, avatar")->find();
            foreach ($userInfo as $key => $value) {
                $chat[$key] = $value;
            }
            
            $chatId = $chat['id'];
            $chat['likedList'] = M('Chat_liked')->where("chat_id = {$chatId}")->select();
            $chat['commentsList'] = M('Chat_comment')->where("chat_id = {$chatId}")->select();
            
            if (date("d", time()) != date("d", $chat['time'])) {
                $chat['time'] = (date("Y", time()) != date("Y", $chat['time'])) ? date("Y-m-d H:i", $chat['time']) : date("m-d H:i", $chat['time']);
            }
        }
        return $data;
    }
    
    public function getCommentsWithId($id) {
        $data = M('Chat_comment')->where("chat_id = {$id}")->order("floor desc")->select();
        foreach ($data as &$comment) {
            $userId = $comment['user_id'];
            $userInfo = M('User')->where("id = {$userId}")->field("name, gender, avatar")->find();
            foreach ($userInfo as $key => $value) {
                $comment[$key] = $value;
            }
        
            if (date("d", time()) != date("d", $comment['time'])) {
                $comment['time'] = (date("Y", time()) != date("Y", $comment['time'])) ? date("Y-m-d H:i", $comment['time']) : date("m-d H:i", $comment['time']);
            }
        }
        return $data;
    }
    
    public function like($chatId, $userId) {
        $data['chat_id'] = $chatId;
        $data['user_id'] = $userId;
        $id = M('Chat_liked')->data($data)->add();
        if (!$id) {
            return false;
        }
        return true;
    }
    
    public function unlike($chatId, $userId) {
        $id = M('Chat_liked')->where("chat_id = {$chatId} and user_id = {$userId}")->delete();
        if (!$id) {
            return false;
        }
        return true;
    }
}