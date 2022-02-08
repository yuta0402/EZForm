<?php

namespace EZForm;

class Validation
{
  function __construct($form_settings)
  {
    $this->form_settings = $form_settings;
    $this->form_list = array_column($form_settings['form_list'], null, 'name');
    $this->form_keys = array_column($form_settings['form_list'], 'name');
    $this->error_message_list = array_column($form_settings['error_message_list'], null, 'type');
  }

  public $errors = [];

  public function checkAll(array $inputs): void
  {
    foreach ($this->form_list as $key => $setting) {
      $input_value = $inputs[$key] ?? null;
      if ($setting['required']) {
        if (!$this->checkRequired($input_value)) {
          $this->setErrorMessage($setting, "required");
          continue;
        }
      }
      $validation_type = $setting['validation_type'];
      if ($validation_type) {
        if (!$this->validateByType($input_value, $validation_type)) {
          $this->setErrorMessage($setting, $validation_type);
        }
      }
    }
  }

  private function validateByType($value, $type)
  {

    switch ($type) {
      case 'email':
        $result = $this->checkEmail($value);

        break;

      case 'tel';
        $result = $this->checkTel($value);

        break;

      case 'kana';
        $result = $this->checkKana($value);

        break;
    }
    return $result;
  }
  private function setErrorMessage($setting, $validation_type = "required")
  {
    $this->errors[$setting['name']] = str_replace(':name', $setting['label'], $this->error_message_list[$validation_type]);
  }

  public function h($var)
  {
    if (is_array($var)) {
      return array_map([$this, 'h'], $var);
    } else {
      return nl2br(htmlspecialchars($var, ENT_QUOTES, 'UTF-8'));
    }
  }

  public function superTrim($var)
  {
    if (is_array($var)) {
      return array_map([$this, 'superTrim'], $var);
    } else {
      return preg_replace('/\A[\p{C}\p{Z}]++|[\p{C}\p{Z}]++\z/u', '', $var);
    }
  }

  public function checkRequired($var): bool
  {
    return ($var !== '' && isset($var)) ? true : false;
  }

  function checkEmail($mail)
  {
    if (!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $mail)) {
      return false;
    }
    return true;
  }

  public function checkTel($tel)
  {
    if (!preg_match("/^[0-9]+$/", $tel)) {
      return false;
    }
    return true;
  }

  public function checkKana($kana)
  {
    if (!preg_match("/^[ァ-ヾ]+$/u", $kana)) {
      return false;
    }
    return true;
  }
}
