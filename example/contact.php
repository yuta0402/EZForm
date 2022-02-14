<?php
require_once ('../EZform/vendor/autoload.php');
$ez = EZForm\Form::EZBuildForm();
?>

<form action="" method="post">
  <input type="text" name="cname" value="<?php $ez->old('cname') ?>">
  <input type="text" name="cnamekana" value="<?php $ez->old('cname') ?>">
  <input type="text" name="tname" value="<?php $ez->old('cname') ?>">
  <input type="email" name="email" value="<?php $ez->old('email') ?>">
  <input type="submit" value="submit">

</form>

<?php
?>