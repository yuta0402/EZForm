<?php
// 必要
require_once('../EZform/vendor/autoload.php');
$ez = EZForm\Form::EZBuildConfirm();

var_dump($ez);
// 必要
?>

<!-- 記述例 -->
<table class="form confirm">

    <?php $key = 'cname'?> 
    <tr>
        <th><?php $ez->label($key)?></th>
        <td>
            <?php $ez->old($key) ?>
        </td>
    </tr>

    <?php $key = 'cnamekana'?> 
    <tr>
        <th><?php $ez->label($key)?></th>
        <td>
            <?php $ez->old($key) ?>
        </td>
    </tr>

    <?php $key = 'zipcode'?> 
    <tr>
        <th><?php $ez->label($key)?></th>
        <td>
            <?php $ez->old($key) ?>
        </td>
    </tr>

    <?php $key = 'email'?> 
    <tr>
        <th><?php $ez->label($key)?></th>
        <td>
            <?php $ez->old($key) ?>
        </td>
    </tr>
    
    <?php $key = 'pp'?> 
    <tr>
        <th><?php $ez->label($key)?></th>
        <td>
            <?php $ez->old($key) ?>
        </td>
    </tr>
    <?php $key = 'checkbox'?> 
    <tr>
        <th><?php $ez->label($key)?></th>
        <td>
            <?php $ez->old($key) ?>
        </td>
    </tr>
</table>
<!-- 記述例 -->

<!-- 必要 -->
<form action="?" method="POST">
    <?php $ez->token() ?>
    <button type="submit">送信する</button>
    <a href="javascript:void(0)" onclick="window.history.back(); cursor">戻る</a>
</form>
<!-- 必要 /-->