<?php

// フォームヘルパー関数をロード
require '../Chapter6/formhelpers.php';

try{
    $dns = 'mysql:host=localhost;dbname=rensyu;charset=utf8';
    $username = 'yamauchi';
    $password = 'p';
    $db = new PDO($dns, $username, $password);
}catch(PDOexception $e){
    var_dump($e);
}

//var_dump($db);

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
    // この関数内で、グローバル変数の$dbにアクセスする
    global $db;

    try{
    
        // 問い合わせのSQL文を作成
        $sql = 'SELECT dish_name, price, is_spicy FROM dishes WHERE
                price >= ? AND price <= ?';

        // 料理名が入っていれば、where句に追加
        // ユーザが入力したSQLのワイルドカードを避けるために
        // quote()とstrtr()を追加
        if (strlen(trim($_POST['dish_name']))) {
            $dish = $db->quote($_POST['dish_name']);
            $dish = strtr($dish, array('_' => '\_', '%' => '\%'));

            // 部分一致で検索できるように検索文字列の前後に%を追加
            $dish = preg_replace('/^\'/', '\'%', $dish);
            $dish = preg_replace('/\'$/', '%\'', $dish);

            $sql .= " AND dish_name LIKE $dish";
        }

        // is_spicyが"yes" または "no"の時はSQLを追加
        // "either"なら何もしない
        $spicy_choice = $GLOBALS['spicy_choices'][ $_POST['is_spicy'] ];
        if ($spicy_choice == 'yes') {
            $sql .= ' AND is_spicy = 1';
        } elseif ($spicy_choice == 'no') {
            $sql .= ' AND is_spicy = 0';
        }

        // プリペアードクエリ
        $sth = $db->prepare($sql);
        $sth->execute(array($_POST['min_price'],$_POST['max_price']));
        // フェッチモードをオブジェクトに設定
        $sth->setFetchMode(PDO::FETCH_OBJ);
        // 結果の取得
        $dishes = $sth->fetchAll();
        
        if (count($dishes) == 0) {
            print 'No dishes matched.';
        } else {
            print '<table>';
            print '<tr><th>Dish Name</th><th>Price</th><th>Spicy?</th></tr>';
            foreach ($dishes as $dish) {
                if ($dish->is_spicy == 1) {
                    $spicy = 'Yes';
                } else {
                    $spicy = 'No';
                }
                printf('<tr><td>%s</td><td>$%.02f</td><td>%s</td></tr>',
                       htmlentities($dish->dish_name), $dish->price, $spicy);
            }
        }
    }catch(PDOexception $e){
        var_dump($e);
    }
}
?>