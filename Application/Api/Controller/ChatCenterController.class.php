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
}