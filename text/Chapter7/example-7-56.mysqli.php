<?php

// フォームヘルパー関数をロード
require '../Chapter6/formhelpers.php';

// mysqliによるデータベース接続
// ドメイン名、ユーザ名、パスワード、データベース名
$db = mysqli_connect('localhost','yamauchi','p','rensyu');
if (! $db) { die("Can't connect: " . mysqli_connect_error()); }

/* 文字セットを utf8 に変更します */
if (!mysqli_set_charset($db, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($db));
    exit();
}

// フォームのメニューでの"spicy"の選択肢
$spicy_choices = array('no','yes','either');

// メインページのロジック:
// - フォームがサブミットされたら、
//    検証し、処理またはエラー付きフォーム表示
// - フォームがサブミットされていない場合はフォームを表示
if (array_key_exists('_submit_check', $_POST)) {
    // If validate_form() returns errors, pass them to show_form()
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        // サブミットされた値が妥当であれば、それを処理
        process_form();
    }
} else {
    // フォームがサブミットされなければ、フォームを表示
    show_form();
}

function show_form($errors = '') {
    // フォームがサブミットされたら、サブミットされた
    // パラメータからデフォルトを取り出す
    if (array_key_exists('_submit_check', $_POST)) {
        $defaults = $_POST;
    } else {
        // サブミットされていなければ、独自のデフォルトをセット
        $defaults = array('min_price' => '5.00',
                          'max_price' => '25.00',
                          'dish_name' => '',
                          );
    }
    
    // エラーが渡されると、$error_textに代入(HTMLマークアップ形式)
    if (is_array($errors)) {
        $error_text = '<tr><td>You need to correct the following errors:';
        $error_text .= '</td><td><ul><li>';
        $error_text .= implode('</li><li>',$errors);
        $error_text .= '</li></ul></td></tr>';
    } else {
        // エラーがなければ、$error_textは空を設定
        $error_text = '';
    }

    // Jump out of PHP mode to make displaying all the HTML tags easier
?>
<form method="POST" action="<?php print $_SERVER['PHP_SELF']; ?>">
<table>
<?php print $error_text ?>

<tr><td>Dish Name:</td>
<td><?php input_text('dish_name', $defaults) ?></td></tr>

<tr><td>Minimum Price:</td>
<td><?php input_text('min_price', $defaults) ?></td></tr>

<tr><td>Maximum Price:</td>
<td><?php input_text('max_price', $defaults) ?></td></tr>

<tr><td>Spicy:</td>
<td><?php input_select('is_spicy', $defaults, $GLOBALS['spicy_choices']); ?>
</td></tr>

<tr><td colspan="2" align="center"><?php input_submit('search','Search'); ?>
</td></tr>

</table>
<input type="hidden" name="_submit_check" value="1"/>
</form>
<?php
      } // show_form()の終わり

function validate_form() {
    $errors = array();

    // 最低価格は妥当な浮動小数点数でなくてはならない
    if ($_POST['min_price'] != strval(floatval($_POST['min_price']))) {
        $errors[] = 'Please enter a valid minimum price.';
    }

    // 最高価格は妥当な浮動小数点数でなくてはならない
    if ($_POST['max_price'] != strval(floatval($_POST['max_price']))) {
        $errors[] = 'Please enter a valid maximum price.';
    }

    // 最低価格は最高価格より低くなくてはならない
    if ($_POST['min_price'] >= $_POST['max_price']) {
        $errors[] = 'The minimum price must be less than the maximum price.';
    }

    if (! array_key_exists($_POST['is_spicy'], $GLOBALS['spicy_choices'])) {
        $errors[] = 'Please choose a valid "spicy" option.';
    }
    return $errors;
}

function process_form() {
    // Access the global variable $db inside this function
    global $db;
    
    // build up the query 
    $sql = 'SELECT dish_name, price, is_spicy FROM dishes WHERE ';
    
    // add the minimum price to the query
    $sql .= "price >= '" .
            mysqli_real_escape_string($db, $_POST['min_price']) . "' ";

    // add the maximum price to the query
    $sql .= " AND price <= '" .
            mysqli_real_escape_string($db, $_POST['max_price']) . "' ";

    // if a dish name was submitted, add to the WHERE clause
    // we use mysqli_real_escape_string() and strtr() to prevent
    // user-entered wildcards from working
    if (strlen(trim($_POST['dish_name']))) {
        $dish = mysqli_real_escape_string($db, $_POST['dish_name']);
        $dish = strtr($dish, array('_' => '\_', '%' => '\%'));
        // mysqli_real_escape_string() doesn't add the single quotes
        // around the value so you have to put those around $dish in
        // the query:

        // 部分一致で検索できるように検索文字列の前後に%を追加
        $dish = '%' . $dish . '%';

        $sql .= " AND dish_name LIKE '$dish'";
    }

    // if is_spicy is "yes" or "no", add appropriate SQL
    // (if it's either, we don't need to add is_spicy to the WHERE clause)
    $spicy_choice = $GLOBALS['spicy_choices'][ $_POST['is_spicy'] ];
    if ($spicy_choice == 'yes') {
        $sql .= ' AND is_spicy = 1';
    } elseif ($spicy_choice == 'no') {
        $sql .= ' AND is_spicy = 0';
    }

    // Send the query to the database program and get all the rows back
    $q = mysqli_query($db, $sql);

    if (!$q) {
        printf("Errormessage: %s\n", mysqli_error($db));
        var_dump($sql);
        exit();
    }

    if (mysqli_num_rows($q) == 0) {
        print 'No dishes matched.';
    } else {
        print '<table>';
        print '<tr><th>Dish Name</th><th>Price</th><th>Spicy?</th></tr>';
        while ($dish = mysqli_fetch_object($q)) {
            if ($dish->is_spicy == 1) {
                $spicy = 'Yes';
            } else {
                $spicy = 'No';
            }
            printf('<tr><td>%s</td><td>$%.02f</td><td>%s</td></tr>',
                   htmlentities($dish->dish_name), $dish->price, $spicy);
        }
    }
}

?>