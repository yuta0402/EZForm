<?php
// 必要
require_once('../EZform/vendor/autoload.php');
$ez = EZForm\Form::EZBuildConfirm();
// 必要
?>


<input type="text" name="cname" value="<?php $ez->old('cname') ?>">
<input type="text" name="cnamekana" value="<?php $ez->old('cname') ?>">
<input type="text" name="tname" value="<?php $ez->old('cname') ?>">


<!-- 必要 -->

<form action="?" method="POST">
    <button type="submit">送信する</button>
    <a href="javascript:void(0)" onclick="window.history.back(); cursor">戻る</a>
</form>
<!-- 必要 /-->