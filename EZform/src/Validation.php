<?php

namespace EZForm;

class Validation
{
  public  static function h($var)
  {
    if (is_array($var)) {
      return array_map('self::h', $var);
    } else {
      return nl2br(htmlspecialchars($var, ENT_QUOTES, 'UTF-8'));
    }
  }

  public static function superTrim($var)
  {
    if (is_array($var)) {
      return array_map('self::superTrim', $var);
    } else {
      return preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $var);
    }
  }

  public static function checkRequired($var): bool
  {
    return ($var !== '' && isset($var)) ? true : false;
  }

  public static  function checkEmail($mail)
  {
    if (!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $mail)) {
      return false;
    }
    return true;
  }

  public static function checkTel($tel)
  {
    if (!preg_match("/^[0-9]+$/", $tel)) {
      return false;
    }
    return true;
  }

  public static function checkKana($kana)
  {
    if (!preg_match("/^[ァ-ヾ]+$/u", $kana)) {
      return false;
    }
    return true;
  }

  public static function checkZipcode($kana)
  {
    if (!preg_match("/^[0-9]{7}$/", $kana)) {
      return false;
    }
    return true;
  }
}
