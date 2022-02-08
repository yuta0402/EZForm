<?php

namespace EZForm;

class Form extends Validation
{

  private $inputs = [];
  private $has_submit = false;

  public function buildForm()
  {
    $this->inputs = $this->superTrim($_POST);

    if ($this->inputs) {
      $this->has_submit = true;
      $this->checkAll($this->inputs);
    }

    if ($this->has_submit && count($this->errors) === 0) {
      header('Expires:-1');
      header('Cache-Control:');
      header('Pragma:');
      $_SESSION['ez_form'] = $this->inputs;
      header('Location: ' . $this->form_settings['comfirm_page_name'], true , 301);
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
}
