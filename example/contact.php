<?php
require_once('../EZform/vendor/autoload.php');
$ez = EZForm\Form::EZBuildForm();
?>


<form action="" method="post">

  <div>

    <?php $key  = 'cname'; ?>
    <?php $ez->label($key) ?>
    <input type="<?php $ez->type($key) ?>" name="<?php $ez->name($key) ?>" value="<?php $ez->old($key) ?>">
    <div class="error">
      <?php $ez->error($key) ?>
    </div>
  </div>
  <div>

    <?php $key  = 'cnamekana'; ?>
    <?php $ez->label($key) ?>
    <input type="<?php $ez->type($key) ?>" name="<?php $ez->name($key) ?>" value="<?php $ez->old($key) ?>">
    <div class="error">
      <?php $ez->error($key) ?>
    </div>
  </div>

  <div>
    <?php $key  = 'zipcode'; ?>
    <?php $ez->label($key) ?>
    <input type="<?php $ez->type($key) ?>" name="<?php $ez->name($key) ?>" value="<?php $ez->old($key) ?>">
    <div class="error" <?= $ez->error($key) ? 'style=display:block;' : '' ?>>
      <?= $ez->error($key) ?>
    </div>
  </div>

  <div>
    <?php $key  = 'email'; ?>
    <?php $ez->label($key) ?>
    <input type="<?php $ez->type($key) ?>" name="<?php $ez->name($key) ?>" value="<?php $ez->old($key) ?>">
    <div class="error" <?= $ez->error($key) ? 'style=display:block;' : '' ?>>
      <?= $ez->error($key) ?>
    </div>
  </div>
  <input type="submit" value="送信">

</form>

<?php
?>