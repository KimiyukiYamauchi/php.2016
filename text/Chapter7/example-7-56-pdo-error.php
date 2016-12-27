<?php
echo 'MDB2とPDOのプログラムの記述の比較';
// PEARのMDB2モジュールをロード
// require 'MDB2.php';
// フォームヘルパー関数をロード
require '../Chapter6/formhelpers.php';

// Connect to the database
//$db = MDB2::connect('mysqli://yamashiro:pass@localhost/rensyu?charset=utf8');
//f (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); //}
try{
    $dns = 'mysql:localhost;dbname=rensyu;charset=utf8';
    $username = 'yamauchi';
    $password = 'p';
    $db = new PDO($dns,$username,$password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOexception $e) {
    var_dump($e);
}

// 自動でエラーハンドリングを設定
//$db->setErrorHandling(PEAR_ERROR_DIE);

// フェッチモードを設定：行をオブジェクトとする
//$db->setFetchMode(MDB2_FETCHMODE_OBJECT);

// フォームのメニューでの spicy の選択肢
$spicy_choices = array('no','yes','either');

// メインページのロジック
// - フォームがサブミットされたら、検証し、処理またはエラー付きフォーム表示
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
    // フォームがサブミットされたら、
    // サブミットされたパラメータからデフォルトを取り出す
    if (array_key_exists('_submit_check', $_POST)) {
        $defaults = $_POST;
    } else {
        // サブミットされていなければ、独自のデフォルトをセット
        $defaults = array('min_price' => '5.00',
                          'max_price' => '25.00',
                          'dish_name' => ''
                          );
    }

    // エラーが渡されると、 $error_text に代入
    if (is_array($errors)) {
        $error_text = '<tr><td>You need to correct the following errors:';
        $error_text .= '</td><td><ul><li>';
        $error_text .= implode('</li><li>',$errors);
        $error_text .= '</li></ul></td></tr>';
    } else {
        // エラーがない場合は、何も出力しない
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
} // The end of show_form()

function validate_form() {
    $errors = array();

    // 最低価格は妥当な浮動小数点かどうかのチェック
    if ($_POST['min_price'] != strval(floatval($_POST['min_price']))) {
        $errors[] = 'Please enter a valid minimum price.';
    }

    // 最高価格は妥当な浮動小数点かどうかのチェック
    if ($_POST['max_price'] != strval(floatval($_POST['max_price']))) {
        $errors[] = 'Please enter a valid maximum price.';
    }

    // 最高価格と最低価格の妥当性をチェック
    if ($_POST['min_price'] >= $_POST['max_price']) {
        $errors[] = 'The minimum price must be less than the maximum price.';
    }

    if (! array_key_exists($_POST['is_spicy'], $GLOBALS['spicy_choices'])) {
        $errors[] = 'Please choose a valid "spicy" option.';
    }
    return $errors;
}

function process_form() {
    // この関数内で、グローバル変数の$dbを読み込む
    global $db;

    try {
        // 問い合わせのSQL文を記述
        //$sql = 'SELECT dish_name, price, is_spicy FROM dishes WHERE
        //        price >= :min_price AND price <= :max_price';
         $sql = 'SELECT dish_name, price, is_spicy FROM dishes WHERE
                price >= 1 AND price <= 25';

        // 料理名が入っていれば、where句に追加
        // ユーザーが入力したSQLのワイルドカードを避ける quote()とstrtr() を追加
        if (strlen(trim($_POST['dish_name']))) {
            $dish = $db->quote($_POST['dish_name']);
            $dish = strtr($dish, array('_' => '\_', '%' => '\%'));

            // 部分一致で検索できるように検索文字列の前後に％を追加
            $dish = preg_replace('/^\'/', '\'%', $dish);
            $dish = preg_replace('/\'$/', '%\'', $dish);

            $sql .= " AND dish_name LIKE $dish";
        }

        // if is_spicy が "yes" or "no" の時はSQLを追加
        // either なら何もしない
        $spicy_choice = $GLOBALS['spicy_choices'][ $_POST['is_spicy'] ];
        if ($spicy_choice == 'yes') {
            $sql .= ' AND is_spicy = 1';
        } elseif ($spicy_choice == 'no') {
            $sql .= ' AND is_spicy = 0';
        }

        // クエリをDBプログラムに送り、戻ってくるすべての行を取得

        $sth = $db->prepare($sql);

        //var_dump($sth);

        //$result = $sth->execute(array($_POST['min_price'], $_POST['max_price']));
        //$dishes = $result->fetchAll();
        //$ret = $sth->execute(array($_POST['min_price'],$_POST['max_price']));
        //$ret = $sth->execute(array(':min_price' => $_POST['min_price'],
         //                           ':max_price' => $_POST['max_price']));
        $ret = $sth->execute(array());
        //var_dump($ret);

        // フェッチモードの設定
        $sth->setFetchMode(PDO::FETCH_OBJ);
        // 結果の取得
        $dishes = $sth->fetchAll();


        var_dump($sql);
        var_dump($dishes);

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
    } catch (PDOexception $e) {
        var_dump($e);
    }
}
?>