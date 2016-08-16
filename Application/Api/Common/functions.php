<?php
/**
 * functions.php
 * Created by PhpStorm.
 * Author: xiaoyu
 * Time: 8/15/16 15:18
 */

/**
 * 发送手机验证码,成功返回验证码,失败返回0
 *
 * @param string $tel 接受验证码的手机号
 *
 * @return string
 */
function send_verify_code($tel) {
    return "" . rand(1000, 9999) . "";
}

/**
 * 生成指定长度的随机字符串
 *
 * @param string $length 字符串长度
 *
 * @return string
 */
function create_random_string($length) {
    $randomString = "";
    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    for ($i = 1; $i <= $length; $i++) {
        $randomString .= $str[rand(0, strlen($str))];
    }
    return $randomString;
}

/**
 * 生成token
 *
 * @param string $tel 手机号,用于生成token
 *
 * @return string
 */
function create_token($tel) {
    return md5(md5('ego' . $tel . time() . rand(1000, 9999)));
}