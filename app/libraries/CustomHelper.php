<?php

use Carbon\Carbon;

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
                if ($post !== $allowedPosts) {
                    throw new \Exception(\Lang::get('errors.invalid_post_request'));
                }
            }
            return true;
        }
        throw new \Exception(\Lang::get('errors.invalid_post_request'));
    }

    public static function generateRandomDigitCode($length = 4)
    {
        $numbers = '0123456789';
        $randomDigit = '';
        for ($i = 0; $i < $length; $i++) {
            $randomDigit .= $numbers[rand(0, strlen($numbers) - 1)];
        }
        if ($length != strlen($randomDigit)) {
            $len = "";
            for ($j = 0; $j < $length; $j++) {
                $len .= 9;
            }
            return rand(0, $len);
        } else {
            return $randomDigit;
        }
    }

    public static function getAddressFromApi($coordinate = null, $radius = '500')
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=' . $coordinate . '&radius=' . $radius . '&key=' . GOOGLE_API_KEY . '');

        $place = json_decode($response->getBody());
        if ($place->status === 'OK') {
            $place = $place->results[0];

            // get timezone
            $response = $client->get('https://maps.googleapis.com/maps/api/timezone/json?location=' . $coordinate . '&timestamp=' . time() . '&key=' . GOOGLE_API_KEY . '');
            $timezone = json_decode($response->getBody());
            $timezone = $timezone->status === 'OK' ? $timezone->timeZoneId : '';

            //get country
            $response = $client->get('https://maps.googleapis.com/maps/api/place/details/json?placeid=' . $place->place_id . '&key=' . GOOGLE_API_KEY . '');
            $country = json_decode($response->getBody());

            $countryISO = $country->status === 'OK' ? $country->result->address_components[2]->short_name : '';
            $countryName = $country->status === 'OK' ? $country->result->address_components[2]->long_name : '';

            return (object)array(
                'name' => $place->vicinity,
                'coordinate' => $place->geometry->location->lat . ',' . $place->geometry->location->lng,
                'timezone' => $timezone,
                'countryISO' => $countryISO,
                'countryName' => $countryName
            );
        }
        return false;
    }

    public static function dateConvertTimezone($dt, $timezone, $format)
    {
        return $dt->tz($timezone)->$format();
    }

    public static function generateRandomCharacters($length = 6)
    {
        $characters = '23456789abcdefghijkmnpqrstuvwxyz';
        $randomCharacter = '';
        for ($i = 0; $i < $length; $i++) {
            $randomCharacter .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomCharacter;
    }
} 