<?php
/**
 * BuildingController.class.php
 * Created by PhpStorm.
 * Author: xiaoyu
 * Time: 8/25/16 21:04
 */

namespace Api\Controller;

use Api\Controller\BaseController;

class BuildingController extends BaseController
{
    /**
     * 获取建筑物位置信息,成功返回建筑物信息,失败返回错误信息
     * @access public
     *
     * @param integer|null $id 要查询的建筑物id,不指定则获取所有建筑物信息
     */
    public function getBuildingLocation_get($id = null) {
        $busInfo = D('Building')->getBuildingInfo($id);
        if (!$busInfo) {
            $this->response(array('error' => '未找到相关信息'), 'json', 404);
        }
        $this->response($busInfo, 'json', 200);
    }
}