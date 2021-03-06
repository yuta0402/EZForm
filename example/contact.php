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

  <div>
    <?php $key  = 'email_kakunin'; ?>
    <?php $ez->label($key) ?>
    <input type="<?php $ez->type($key) ?>" name="<?php $ez->name($key) ?>" value="<?php $ez->old($key) ?>">
    <div class="error" <?= $ez->error($key) ? 'style=display:block;' : '' ?>>
      <?= $ez->error($key) ?>
    </div>
  </div>


  <div>
    <?php $key  = 'pp'; ?>
    <?php $ez->label($key) ?>
    <?php
    $options = $ez->options($key);
    ?>

    <?php foreach ($options as $k => $label) { ?>

      <label for="<?= $ez->name($key) . $k ?>"><?= $label ?></label>

      <input type="<?php $ez->type($key) ?>" name="<?php $ez->name($key) ?>" value="<?= $label ?>" <?php echo isset($ez->inputs[$key]) && in_array($label, $ez->inputs[$key]) ? 'checked' : '' ?>>
    <?php } ?>
    <div class="error" <?= $ez->error($key) ? 'style=display:block;' : '' ?>>
      <?= $ez->error($key) ?>
    </div>

  </div>

  <div>
    <?php $key  = 'checkbox'; ?>
    <?php $ez->label($key) ?>
    <?php
    $options = $ez->options('checkbox');
    ?>

    <?php foreach ($options as $k => $label) { ?>

      <label for="<?= $ez->name($key) . $k ?>"><?= $label ?></label>

      <input type="<?php $ez->type($key) ?>" name="<?php $ez->name($key) ?>" value="<?= $label ?>" <?php echo isset($ez->inputs[$key]) && in_array($label, $ez->inputs[$key]) ? 'checked' : '' ?>>
    <?php } ?>
    <div class="error" <?= $ez->error($key) ? 'style=display:block;' : '' ?>>
      <?= $ez->error($key) ?>
    </div>

  </div>
  <input type="submit" value="??????">

</form>