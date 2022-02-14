<?php
require_once ('../EZform/vendor/autoload.php');
$ez = EZForm\Form::EZBuildForm();
?>


<form action="" method="post">
  <input type="text" name="cname" value="<?php $ez->old('cname') ?>">
  <input type="text" name="cnamekana" value="<?php $ez->old('cname') ?>">
  <input type="text" name="tname" value="<?php $ez->old('cname') ?>">
  <input type="email" name="email" value="<?php $ez->old('email') ?>">
  
<?php
$key  = 'zipcode';
// var_dump($ez->errors);
?>
<?= $ez->form_list[$key]['label']?>
<?= $ez->form_list[$key]['name']?>
  <input type="text" name="zipcode">
  <div class="error" <?= $ez->error($key) ? 'style=display:block;' : '' ?>>
    <?= $ez->error($key) ?>
</div>
  <input type="submit" value="送信">

</form>

<?php
?>