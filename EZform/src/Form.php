<?php

namespace EZForm;

use EZForm\Mailer;
use EZForm\Validation;

class Form
{
  public $inputs;
  public $form_settings;
  public $form_list;
  public $form_keys;
  public $error_message_list;

  public $mail_body;
  public $mail_to;


  function __construct($form_settings, $input)
  {

    // parent::__construct($form_settings);
    // $this->validation = new Validation(); //static
    $this->inputs = Validation::superTrim($input);

    $this->form_settings = $form_settings;
    $this->form_list = array_column($form_settings['form_list'], null, 'name');
    $this->form_keys = array_column($form_settings['form_list'], 'name');
    $this->error_message_list = array_column($form_settings['error_message_list'], null, 'type');
  }
  public function buildContactPage()
  {
    if ($this->inputs) {
      $this->checkAll($this->inputs);
    }
    
    if ($this->inputs && count($this->errors) === 0) {
      header('Expires:-1');
      header('Cache-Control:');
      header('Pragma:');
      session_start();
      $_SESSION['ez_form'] = $this->inputs;
      header('Location: ' . $this->form_settings['confirm_page_name'], true, 301);
      exit();
    }

  }
  public function checkAll(array $inputs): void
  {
    foreach ($this->form_list as $key => $setting) {
      $input_value = $inputs[$key] ?? null;
      if ($setting['required']) {
        if (!Validation::checkRequired($input_value)) {
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
        $result = Validation::checkEmail($value);

        break;

      case 'tel';
        $result = Validation::checkTel($value);

        break;

      case 'kana';
        $result = Validation::checkKana($value);

        break;

      case 'zipcode';
        $result = Validation::checkZipcode($value);

        break;
    }
    return $result;
  }
  private function setErrorMessage($setting, $validation_type = "required")
  {
    $this->errors[$setting['name']] = str_replace(':name', $setting['label'], $this->error_message_list[$validation_type])['message'];
  }

  public function echoSafely(string $str)
  {
    echo Validation::h($str);
  }

  /**
   * 前の入力を表示します
   *
   * @param [type] $key
   * @param string $default
   * @return string
   */
  public function old($key, $default = '')
  {
    $value = (isset($this->inputs[$key]))  ? $this->inputs[$key] : $default;
    return $this->echoSafely($value);
  }

  public function buildConfirmPage()
  {
    if (empty($this->inputs)) {
      header('Location: ' . $this->form_settings['contact_page_name'], true, 301);
    }
  }

  public function sendMail()
  {
    $ez_mailer = new Mailer($this->form_settings['mail']);
    $pattern = "/{{(.+?)}}/";
    $this->mail_body = $this->replaceBody($pattern, $this->mail_body);
    $ez_mailer->sendMail($this->mail_body, $this->inputs['email']);
    unset($_SESSION['ez_form']);
    header('Location: ' . $this->form_settings['complete_page_name'], true, 301);
    exit();
  }

  public function replaceBody($pattern, $base)
  {
    return preg_replace_callback($pattern, function ($matches) {
      return $this->inputs[$matches[1]] ?? '';
    }, $base);
  }

  public static function EZBuildForm()
  {
    $ez = new self(json_decode(file_get_contents(__DIR__ . "/../config/form_settings.json"), true), $_POST);
    $ez->buildContactPage();
    return $ez;
  }
  public static function EZBuildConfirm()
  {
    session_start();
    $ez = new self(json_decode(file_get_contents(__DIR__ . "/../config/form_settings.json"), true), $_SESSION['ez_form'] ?? null);
    $ez->buildConfirmPage();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $ez->mail_body = nl2br(file_get_contents(__DIR__ . "/../config/mail_body.txt"));
      $ez->sendMail();
    }
    return $ez;
  }

  public function error($key)
  {
    if (isset($this->errors[$key])) {
      $this->echoSafely($this->errors[$key]);
    }
  }
}
