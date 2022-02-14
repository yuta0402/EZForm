<?php

namespace EZForm;

use EZForm\Mailer;

class Form extends Validation
{

  public $inputs = [];
  private $has_submit = false;
  public $mail_body;
  public $mail_to;


  function __construct($form_settings, $input)
  {
    parent::__construct($form_settings);
    $this->inputs = $this->superTrim($input);
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

  public function echoSafely(string $str)
  {
    echo $this->h($str);
  }

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
    $ez = new self(json_decode(file_get_contents(__DIR__ . "/../config/form_settings.json"), true),$_SESSION['ez_form'] ?? null);
    $ez->buildConfirmPage();
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $ez->mail_body = nl2br(file_get_contents(__DIR__."/../config/mail_body.txt"));
      $ez->sendMail();
    }
    return $ez;
  }
}
