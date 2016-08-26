<?php
/**
 * BusModel.class.php
 * Created by PhpStorm.
 * Author: xiaoyu
 * Time: 8/24/16 19:10
 */

namespace Api\Model;

use Api\Model\BaseModel;

class BusModel extends BaseModel
{
    /**
     * 获取小白信息,成功返回相应信息,失败返回false
     * @access public
     *
     * @param integer $id 要获取的小白id,为null时则获取所有小白信息
     *
     * @return bool|mixed
     */
    public function getBusInfo($id) {
        if ($id == null) {
            $buses = M('Bus')->select();
            if (!$buses) {
                return false;
            }
            return $buses;
        } else {
            $bus = M('Bus')->find($id);
            if (!$bus) {
                return false;
            }
            return $bus;
        }
    }
    
    /**
     * 更新小白信息,更新成功返回true,失败返回false
     * @access public
     *
     * @param integer $id        要更新信息的小白id
     * @param double  $latitude  小白当前纬度
     * @param double  $longitude 小白当前经度
     *
     * @return bool
     */
    public function updateBusLocation($id, $latitude, $longitude) {
        $result = M('Bus')->where("id = '{$id}'")->save(array('latitude' => $latitude, 'longitude' => $longitude));
        if (!$result) {
            return false;
        }
        return true;
    }
}