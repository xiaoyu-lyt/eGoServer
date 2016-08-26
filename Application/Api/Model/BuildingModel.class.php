<?php
/**
 * BuildingModel.class.php
 * Created by PhpStorm.
 * Author: xiaoyu
 * Time: 8/25/16 21:06
 */

namespace Api\Model;

use Api\Model\BaseModel;

class BuildingModel extends BaseModel
{
    /**
     * 获取建筑物信息,成功返回相应信息,失败返回false
     * @access public
     *
     * @param integer $id 要获取的建筑物id,为null时则获取所有建筑物信息
     *
     * @return bool|mixed
     */
    public function getBuildingInfo($id) {
        if ($id == null) {
            $buildings = M('Building')->select();
            if (!$buildings) {
                return false;
            }
            return $buildings;
        } else {
            $building = M('Building')->find($id);
            if (!$building) {
                return false;
            }
            return $building;
        }
    }
}