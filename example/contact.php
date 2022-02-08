<?php
require ('../EZform/vendor/autoload.php');
use EZForm\Form;
$form_settings = json_decode(file_get_contents(__DIR__."/form_settings.json"),true);
$ez = new Form($form_settings);
$ez->buildForm();
?>



<form action="" method="post">
  <input type="text" name="cname" value="<?php $ez->old('cname') ?>">
  <input type="text" name="cnamekana" value="<?php $ez->old('cname') ?>">
  <input type="text" name="tname" value="<?php $ez->old('cname') ?>">
  <input type="submit" value="submit">

</form>

<?php
?>