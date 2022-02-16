<?php

namespace EZForm;

use EZForm\Mailer;
use EZForm\Validation;

class Form
{
  /**
   * 入力内容を安全にしたもの
   *
   * @var Array
   */
  public $inputs;

  public $errors = [];

  public $form_settings;
  public $form_list;
  public $form_keys;
  public $error_message_list;

  public $mail_to;


  function __construct($form_settings, $input)
  {
    $this->inputs = Validation::superTrim($input ?? []);

    $this->form_settings = $form_settings;
    $this->form_list = array_column($form_settings['form_list'], null, 'name');
    $this->form_keys = array_column($form_settings['form_list'], 'name');
    $this->error_message_list = array_column($form_settings['error_message_list'], null, 'type');
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
      // 項目にバリデーションタイプが設定されていたら
      if ($validation_type) {
        if (!$this->checkByValidationType($input_value ?? '', $validation_type)) {
          $this->setErrorMessage($setting, $validation_type);
        }
      }
    }
  }

  private function checkByValidationType(string $value, string $type, bool $allowEmpty = true)
  {
    // 空欄許可の場合早期リターン
    // 想定：必須ではないが入力があった場合はバリデーションかけたい場合
    if ($allowEmpty && $value === '') {
      return true;
    }
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
  public function old(string $key, string $default = '')
  {
    $value = (isset($this->inputs[$key]))  ? $this->inputs[$key] : $default;
    return $this->echoSafely($value);
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

    if ($ez->inputs) {
      $ez->checkAll($ez->inputs);
    }

    if ($ez->inputs && count($ez->errors) === 0) {
      header('Expires:-1');
      header('Cache-Control:');
      header('Pragma:');
      session_start();
      $token = bin2hex(random_bytes(32));
      $_SESSION['ez_form'] = $ez->inputs;
      $_SESSION['ez_form']['token'] = $token;
      header('Location: ' . $ez->form_settings['confirm_page_path'], true, 301);
      exit();
    }
    return $ez;
  }
  public static function EZBuildConfirm()
  {
    session_start();
    $ez = new self(json_decode(file_get_contents(__DIR__ . "/../config/form_settings.json"), true), $_SESSION['ez_form'] ?? null);

    // 入力がなかった場合
    if (empty($ez->inputs)) {
      header('Location: ' . $ez->form_settings['contact_page_path'], true, 301);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if ($ez->inputs['token'] !== $_POST['token']) {
        unset($_SESSION['ez_form']);
        header('Location: ' . $ez->form_settings['contact_page_path'], true, 301);
        exit();
      }

      $body_base = nl2br(file_get_contents(__DIR__ . "/../config/mail_body.txt"));
      $ez_mailer = new Mailer($ez->form_settings['mail']);

      $pattern = "/{{(.+?)}}/";
      $mail_body = $ez->replaceBody($pattern, $body_base);

      $to_email = $ez->inputs[$ez->form_settings['mail']['email_form_name']];
      if(!$to_email){
        echo '設定を確認してください';
        die;
      }
      $ez_mailer->sendMail($mail_body, $ez->inputs['email']);

      unset($_SESSION['ez_form']);
      header('Location: ' . $ez->form_settings['complete_page_path'], true, 301);
      exit();
    }
    return $ez;
  }

  public function error($key)
  {
    if (isset($this->errors[$key])) {
      $this->echoSafely($this->errors[$key]);
    }
  }

  public function name(string $key)
  {
    if (isset($this->form_list[$key])) {
      $this->echoSafely($this->form_list[$key]['name']);
    }
  }
  public function label(string $key)
  {
    if (isset($this->form_list[$key])) {
      $this->echoSafely($this->form_list[$key]['label']);
    }
  }
  public function type(string $key)
  {
    if (isset($this->form_list[$key])) {
      $this->echoSafely($this->form_list[$key]['type']);
    }
  }

  public function token()
  {
    $token = $this->inputs['token'];
    echo "<input type='hidden' name='token' value='{$token}'>";
  }
}
