<?php

use Karma\Users\CopUser;
use Karma\Users\IndUser;

class CustomHelper
{

    /**
     * @param $param
     * @return mixed
     */
    public static function generateToken($param)
    {
        return Hash::make($param . time() . rand(1, 999));
    }


    /**
     * @param $toValidate
     * @param $value
     * @return string
     */
    public static function validate($toValidate, $value)
    {
        $return = [];
        foreach ($toValidate as $tv) {
            switch ($tv) {
                case "required":
                    $return[] = !empty($value) ? 'true' : 'errors.required';
                    break;
                case "optional":
                    $return[] = 'true';
                    break;
                case "string":
                    $return[] = is_string($value) ? 'true' : 'errors.string';
                    break;
                case "integer":
                    $return[] = is_numeric($value) ? 'true' : 'errors.integer';
                    break;
                case "array":
                    $return[] = is_array($value) ? 'true' : 'errors.array';
                    break;
                case "object":
                    $return[] = is_object($value) ? 'true' : 'errors.object';
                    break;
                case "email":
                    $return[] = filter_var($value, FILTER_VALIDATE_EMAIL) ? 'true' : 'errors.email';
                    break;
                case "name":
                    $return[] = preg_match("/^[a-zA-Z ]*$/", $value) ? 'true' : 'errors.name';
                    break;
                case "date":
                    $return[] = preg_match("/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/", $value) ? 'true' : 'errors.date';
                    break;
            }

            // validate more cases
            $moreValidate = (explode('=', $tv));
            if (count($moreValidate) > 1) {
                $split = preg_split('/[\s,]+/', $moreValidate[1]);

                foreach ($moreValidate as $v) {
                    // validate enum
                    if ($v === 'enum') {
                        $fails = [];
                        foreach ($split as $s) {
                            if ($value !== $s) {
                                $fails[] = $s;
                            }
                        }
                        if (count($fails) == count($split)) {
                            $return[] = false;
                        }
                    }
                    if ($v === 'minmax') {
                        if (count($split) == 2) {
                            if ($split[0] > strlen($value)) {
                                $return[] = 'errors.min' . $split[0];
                            } elseif ($split[1] < strlen($value)) {
                                $return[] = 'errors.max' . $split[1];
                            }
                        } else {
                            $return[] = false;
                        }
                    }
                    if ($v === 'required') {
                        $split = preg_split('/[\s@]+/', $moreValidate[1]);
                        if (count($split) == 2 && isset($_POST[$split[0]])) {
                            if ($_POST[$split[0]] == $split[1] && empty($value)) {
                                $return[] = 'errors.required';
                            }
                        } else {
                            $return[] = false;
                        }
                    }
                }
            }

        }

        foreach ($return as $r) {
            if (($r !== 'true') OR !$r) {
                return $r;
            }
        }
        return 'true';
    }


    /**
     * @param array $post
     * @param array $allowedPost
     * @param string $allowedPostLength
     * @return bool
     * @throws Exception
     */
    public static function postCheck($post = [], $allowedPost = [], $allowedPostLength = '0')
    {
        $post = (array)$post;
        if (count($post) == $allowedPostLength) {
            if (self::isAssoc($allowedPost)) {
                foreach (array_map(NULL, array_keys($post), array_values($post), array_keys($allowedPost), array_values($allowedPost)) as $k) {
                    list($post_key, $post_value, $allowedPost_key, $allowedPost_value) = $k;
                    $toValidate = (explode('|', $allowedPost_value));
                    $validate = self::validate($toValidate, $post_value);
                    if (($post_key !== $allowedPost_key) OR (!$validate)) {
                        throw new \Exception(\Lang::get('errors.invalid_post_request'));
                    }
                    if ($validate !== 'true') {
                        throw new \Exception(\Lang::get('labels.' . $post_key) . ' ' . \Lang::get($validate));
                    }
                }
            } else {
                foreach (array_map(NULL, array_keys($post), $allowedPost) as $k) {
                    list($post, $allowedPost) = $k;
                    if ($post !== $allowedPost) {
                        throw new \Exception(\Lang::get('errors.invalid_post_request'));
                    }
                }
            }
            return true;
        }
        throw new \Exception(\Lang::get('errors.invalid_post_request'));
    }

    public static function postRequestUserDetailCheck($userType, $token, $id)
    {
        $user =
            $userType === 'copUser' ?
                CopUser::loginCheck($token, $id) :
                IndUser::loginCheck($token, $id);

        if (!$user) {
            throw new \Exception(\Lang::get('errors.invalid_token'));
        }
        $name = $userType == 'copUser' ? $user->userCompanyName : $user->userFname . ' ' . $user->userLname;
        $userType = $userType == 'copUser' ? 'cop' : 'ind';

        return array('name' => $name, 'details' => $user, 'type' => $userType);
    }


    /**
     * @param int $length
     * @return int|string
     */
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


    /**
     * @param null $coordinate
     * @param string $radius
     * @return bool|object
     */
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

            $countryResponse = $country->status === 'OK' ? $country->result->address_components : [];

            foreach ($countryResponse as $iso) {
                $country = Karma\General\Country::selectCountryNameByISO($iso->short_name);
                if ($country) {
                    $countryISO = $country->countryCode;
                    $countryName = $country->countryName;
                    break;
                } else {
                    $countryISO = '';
                    $countryName = '';
                }
            }

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


    /**
     * @param $dt
     * @param $timezone
     * @param $format
     * @return mixed
     */
    public static function dateConvertTimezone($dt, $timezone, $format)
    {
        return $dt->tz($timezone)->$format();
    }


    /**
     * @param int $length
     * @return string
     */
    public static function generateRandomCharacters($length = 6)
    {
        $characters = '23456789abcdefghijkmnpqrstuvwxyz';
        $randomCharacter = '';
        for ($i = 0; $i < $length; $i++) {
            $randomCharacter .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomCharacter;
    }


    /**
     * @param $arr
     * @return bool
     */
    public static function isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
} 