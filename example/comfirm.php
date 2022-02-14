<?php
require_once ('../EZform/vendor/autoload.php');
$ez = EZForm\Form::EZBuildConfirm();
?>


<input type="text" name="cname" value="<?php $ez->old('cname') ?>">
<input type="text" name="cnamekana" value="<?php $ez->old('cname') ?>">
<input type="text" name="tname" value="<?php $ez->old('cname') ?>">

<div class="error" <?= $ez->errors[$key] ? 'style=display:block;' : '' ?>>
									<?= $ez->errors[$key] ?>
								</div>
<!-- 必要 -->
<form action="?" method="POST">
    <!-- <input type="hidden" name="mode" value="send"> -->
    <input type="submit" value="submit">
</form>
<!-- 必要 /-->