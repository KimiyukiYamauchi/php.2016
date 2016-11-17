<?php
require 'MDB2.php'; // PEARのMDB2モジュールをロード

// フォームヘルパー関数をロード
require '../Chapter6/formhelpers.php';

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu?charset=utf8');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// 自動エラーハンドリング設定
$db->setErrorHandling(PEAR_ERROR_DIE);

// メインページのロジック:
// - フォームがサブミットされたら、検証してから処理あるいは表示する
// - サブミットされなければ、表示する
if (array_key_exists('_submit_check', $_POST)) {
    // If validate_form() returns errors, pass them to show_form()
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        // サブミットされた値が妥当であれば、それを処理
        process_form();
    }
} else {
    // フォームがサブミットされなければ、表示
    show_form();
}

function show_form($errors = '') {
    // フォームがサブミットされたら、サブミットされた
    // パラメータからデフォルトを取り出す
    if (array_key_exists('_submit_check', $_POST)) {
        $defaults = $_POST;
    } else {
        // Otherwise, set our own defaults: price is $5
        $defaults = array(
            'dish_name' => '',
            'price' => '5.00',
        );
    }
    
    // エラーが渡されると、$error_text に入れる(HTMLマークアップとともに)
    if (is_array($errors)) {
        $error_text = '<tr><td>You need to correct the following errors:';
        $error_text .= '</td><td><ul><li>';
        $error_text .= implode('</li><li>',$errors);
        $error_text .= '</li></ul></td></tr>';
    } else {
        // No errors? Then $error_text is blank
        $error_text = '';
    }

    // すべてのHTMLタグをより簡単に表示するために、PHPモードを抜ける
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
<table>
<?php print $error_text ?>

<tr><td>Dish Name:</td>
<td><?php input_text('dish_name', $defaults) ?></td></tr>

<tr><td>Price:</td>
<td><?php input_text('price', $defaults) ?></td></tr>

<tr><td>Spicy:</td>
<td><?php input_radiocheck('checkbox','is_spicy', $defaults, 'yes'); ?>
 Yes</td></tr>

<tr><td colspan="2" align="center"><?php input_submit('save','Order'); ?>
</td></tr>

</table>
<input type="hidden" name="_submit_check" value="1"/>
</form>
<?php
      } // show_form()の終わり

function validate_form() {
    $errors = array();

    // dish_name is required
    if (! strlen(trim($_POST['dish_name']))) {
        $errors[] = 'Please enter the name of the dish.';
    }

    // price must be a valid floating point number and 
    // more than 0
    if (floatval($_POST['price']) <= 0) {
        $errors[] = 'Please enter a valid price.';
    }

    return $errors;
}

function process_form() {
    // Access the global variable $db inside this function
    global $db;

    // Get a unique ID for this dish
    $dish_id = $db->nextID('dishes2');

    // Set the value of $is_spicy based on the checkbox
    if (array_key_exists('is_spicy', $_POST)) {
        $is_spicy = 1;
    } else {
        $is_spicy = 0;
    }

    // 新しい料理をテーブルに挿入
    $sth = $db->prepare('INSERT INTO dishes2 (dish_id, dish_name, price, is_spicy) VALUES (?,?,?,?)');
    $sth->execute(array($dish_id, $_POST['dish_name'], $_POST['price'], $is_spicy));

    // 料理を追加したことをユーザに伝える
    print 'Added ' . htmlentities($_POST['dish_name']) . 
          ' to the database.';
}

?>