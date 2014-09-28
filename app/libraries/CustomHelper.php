<?php
/**
 * User: kishan
 * Date: 9/28/14
 * Time: 1:29 PM
 */

class CustomHelper {
    public static function generateToken($param) {
        return Hash::make($param.time().rand(1, 999));
    }
} 