<?php


$sweets = array('puff' => 'Sesame Seed Puff',
                'square' => 'Coconut Milk Gelatin Square',
                'cake' => 'Brown Sugar Cake',
                'ricemeat' => 'Sweet Rice and Meat');

// $_POST配列に _submit_checkキーがあれば
// サブミットされている
if (array_key_exists('_submit_check', $_POST)) {
    // validate_formから返されるエラーメッセージの配列が
    // 空でなければ、エラメッセージ引数として、フォーム表示
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        // エラーメッセージの配列が空の場合は
        // 処理を実行
        process_form();
    }
} else {
    // サブミットされていない場合はフォームを表示
    show_form();
}

// サブミットされた値を処理する
function process_form() {
    echo $GLOBALS['sweets'][$_POST['order']] . 'が選択されました';
}

// Display the form
function show_form($errors = '') {

	// 引数としてエラーメッセージがあればそれを表示
    if ($errors) {
        print 'Please correct these errors: <ul><li>';
        print implode('</li><li>', $errors);
        print '</li></ul>';
    }

    print<<<_HTML_
<form method="post" action="$_SERVER[PHP_SELF]">
Your Order: <select name="order">

_HTML_;
// $val is the option value, $choice is what's displayed
foreach ($GLOBALS['sweets'] as $val => $choice) {
    print "<option value=\"$val\">$choice</option>\n";
}
print<<<_HTML_
</select>
<br/>
<input type="submit" value="Order">
<input type="hidden" name="_submit_check" value="1">
</form>
_HTML_;
}

// サブミットされた値のチェック
function validate_form() {
    // エラーメッセージを格納する配列を初期化
    $errors = array();

    if(!array_key_exists($_POST['order'], $GLOBALS['sweets'])){
    	$errors[] = '注文を正しく選択してください。';
    }


    // エラーメッセージが格納された配列を返す
    // エラーがなければ配列の要素は空
    return $errors;
}