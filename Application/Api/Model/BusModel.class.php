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
    
    public function updateBusLocation($id, $latitude, $longitude) {
        $result = M('Bus')->where("id = '{$id}'")->save(array('latitude' => $latitude, 'longitude' => $longitude));
        if (!$result) {
            return false;
        }
        return true;
    }
}