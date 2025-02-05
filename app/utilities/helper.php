<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\utilities;

/**
 * Description of helper
 *
 * @author developer
 */

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class helper
{
    public static function getTokenInfo()
    {
        // Retrieve the token from the session
        $token = session('jwt_token');
    
        // Check if the token exists in the session
        if (!$token) {
            // Token not found, simply return false or null (handle this in the controller)
            return null;
        }
    
        try {
            // Explicitly set the token and attempt to retrieve the user
            $user = JWTAuth::setToken($token)->toUser();
    
            // Check if the user is successfully retrieved
            if (!$user) {
                // User not authenticated, return null
                return null;
            }
    
            // Return the user object if authentication is successful
            return $user;
        } catch (JWTException $e) {
            // Handle any exception related to token invalidity or other issues
            return null;
        }
    }
    
    public static function slug($string)
    {
        $string = trim($string);
        $separator = '-';
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array('&' => 'and', "'" => '');
        $string = mb_strtolower(trim($string), 'UTF-8');
        $string = str_replace(array_keys($special_cases), array_values($special_cases), $string);
        $string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
        $string = preg_replace("/[^a-z]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }

} // class ends here
