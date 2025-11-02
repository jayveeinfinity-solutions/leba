<?php
/*
Created by Infinity Brackets
Author : John Vincent Bonza
This is not for sale but it's free to use for any web application
*/
class IB_Token {
    public static function generateToken($set = null, $rlength = 64) {
        if ($set === 'MIXED') {
            $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $userset = $charset;
        } elseif($set === 'NUMERIC') {
            $numset = '0123456789';
            $userset = $numset;
        } elseif($set === 'ALPHA') {
            $alphaset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $userset = $alphaset;
        } elseif($set === 'LOWER') {
            $lowerset = 'abcdefghijklmnopqrstuvwxyz';
            $userset = $lowerset;
        } elseif($set === 'UPPER') {
            $upperset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $userset = $upperset;
        } elseif($set === null) {
            $charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $userset = $charset;
        }
        $charLength = strlen($userset);
        $token = '';
        for ($i = 0; $i < $rlength; $i++) {
            $token .= $userset[rand(0, $charLength - 1)];
        }
        return $token;
    }

    public static function checkToken() {
        if (isset($_SESSION['authsess']) === FALSE) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public static function setToken($authID) {
        if (self::checkToken() === FALSE) {
            $_SESSION['authsess'] = TRUE;
            $_SESSION['authtoken'] = $authID;
        } else {
            $_SESSION['authsess'] = FALSE;
        }
    }

    public static function unsetToken() {
        if (self::checkToken() === TRUE) {
            unset($_SESSION['authsess']);
            unset($_SESSION['authtoken']);
            session_destroy();
            header("Location: ./");
        } else {
            header("Location: ./");
        }
    }
}