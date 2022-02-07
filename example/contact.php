

<?php

// モードチェック

// 入力チェック

//　エラー表示処理

//　セッションにぶち込む
// 遷移処理

require ('../EZform/vendor/autoload.php');
use EZForm\Validation;

$form_list = json_decode(file_get_contents(__DIR__."/form_settings.json"),true);

$ez = new Validation($form_list);



if($_POST['mode']){
  die;
  $mode = 'input';
}
?>



<form action="" method="post">
  <input type="text" value="input" name="mode">
  <input type="submit" value="submit">

</form>