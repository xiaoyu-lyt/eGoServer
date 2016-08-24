<?php
/**
 * BusController.class.php
 * Created by PhpStorm.
 * Author: xiaoyu
 * Time: 8/24/16 19:08
 */

namespace Api\Controller;

use Api\Controller\BaseController;

class BusController extends BaseController
{
    public function getBusInfo_get($id = null) {
        $busInfo = D('Bus')->getBusInfo($id);
        if (!$busInfo) {
            $this->response(array('error' => '未找到相关信息'), 'json', 404);
        }
        $this->response($busInfo, 'json', 200);
    }
}