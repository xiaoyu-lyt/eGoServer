<?php
/**
 * SystemImagesController.class.php
 * Created by PhpStorm.
 * Author: xiaoyu
 * Time: 9/7/16 10:49
 */

namespace Api\Controller;
use Api\Controller\BaseController;

class SystemImagesController extends BaseController
{
    public function getLaunchImage_get() {
        $launchImage = M('System_images')->where("property = 'launch'")->getField('value');
        $this->response(array('image' => $launchImage), 'json', 200);
    }
    
    public function getBannerImages_get() {
        $bannerImages = M('System_images')->where("property = 'banner'")->getField('value');
        $this->response(json_decode($bannerImages), 'json', 200);
    }
}