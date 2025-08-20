<?php

  class InputHelper
  {
    public static function sanitizeString($string)
    {
        return filter_var(trim($string), FILTER_SANITIZE_STRING);
    }

    public static function sanitizeEmail($email)
    {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }

    public static function validateEmail($email)
    {
        return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function sanitizeUrl($url)
    {
        return filter_var(trim($url), FILTER_SANITIZE_URL);
    }

    public static function validatePhone($phone)
    {
        return preg_match('/^\+?[0-9]{7,15}$/', $phone);
    }

    public static function sanitizeArray($array)
    {
        return array_map('htmlspecialchars', $array);
    }
  }

?>