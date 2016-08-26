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
    /**
     * 获取小白位置信息,成功返回小白信息,失败返回错误信息
     * @access public
     *
     * @param integer|null $id 要查询的小白id,不指定则获取所有小白信息
     */
    public function getBusInfo_get($id = null) {
        $busInfo = D('Bus')->getBusInfo($id);
        if (!$busInfo) {
            $this->response(array('error' => '未找到相关信息'), 'json', 404);
        }
        $this->response($busInfo, 'json', 200);
    }
    
    /**
     * 更新小白信息,成功不反悔数据,失败返回错误信息
     * @access public
     */
    public function updateBusLocation_put() {
        $id = I('put.id');
        $latitude = I('put.latitude');
        $longitude = I('put.longitude');
        
        if ($latitude == null || $latitude == 0 || $longitude == null || $longitude == 0) {
            $this->response(array('error' => '非法数据'), 'json', 400);
        }
        if (!D('Bus')->updateBusLocation($id, $latitude, $longitude)) {
            $this->response(array('error' => '数据更新失败'), 'json', 500);
        }
        $this->response(array('msg' => '数据更新成功'), 'json', 204);
    }
}