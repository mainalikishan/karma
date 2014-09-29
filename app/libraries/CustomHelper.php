<?php

/**
 * User: kishan
 * Date: 9/28/14
 * Time: 1:29 PM
 */
class CustomHelper
{
    public static function generateToken($param)
    {
        return Hash::make($param . time() . rand(1, 999));
    }

    public static function postCheck($post = [], $allowedPosts = [], $allowedPostLength = '0')
    {
        $post = (array)$post;
        if (count($post) == $allowedPostLength) {
            foreach (array_map(NULL, array_keys($post), $allowedPosts) as $k) {
                list($post, $allowedPosts) = $k;
                if($post !== $allowedPosts) {
                    throw new \Exception(\Lang::get('errors.invalid_post_request'));
                }
            }
            return true;
        }
        throw new \Exception(\Lang::get('errors.invalid_post_request'));
    }
} 