<?php

require '../Chapter6/formhelpers.php';

// データベースにアクセスするため追加 ここから-----V

require 'MDB2.php'; // PEARのMDB2モジュールをロード

// db_program://ユーザ名:パスワード@ドメイン名/データベース名
$db = MDB2::connect('mysqli://yamauchi:p@localhost/rensyu');
if (MDB2::isError($db)) { die("Can't connect: " . $db->getMessage()); }

// この後のデータベースエラーに関してはメッセージを出力して抜け出す
$db->setErrorHandling(PEAR_ERROR_DIE);

// データベースにアクセスするため追加 ここまで-----^


// This is identical to the input_text() function in formhelpers.php but
// prints a password box (in which asterisks obscure what's entered)
// instead of a plain text field
function input_password($field_name, $values) {
    print '<input type="password" name="' . $field_name .'" value="';
    print htmlentities($values[$field_name]) . '">';
}

session_start();

if (array_key_exists('_submit_check', $_POST)) {
    if ($form_errors = validate_form()) {
        show_form($form_errors);
    } else {
        process_form();
    } 
} else {
    show_form();
}

function show_form($errors = '') {

    // エラーになった時、入力値を保持するため$_POSTを設定
    // 但し、最初のページ表示(get)の際はデフォルト値を設定
    // ここから--v
    if (array_key_exists('_submit_check', $_POST)) {
        $defaults = $_POST;
    } else {
        $defaults = array(

            'username' => '',
            'password' => '',

        );
    }
    // ここまで--^

    print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';

    if ($errors) {
        print '<ul><li>';
        print implode('</li><li>',$errors);
        print '</li></ul>';
    } 
    print 'Username: ';
    input_text('username', $defaults);
    print '<br/>';

    print 'Password: ';
    input_password('password', $defaults);
    print '<br/>';

    input_submit('submit','Log In');

    print '<input type="hidden" name="_submit_check" value="1"/>';
    print '</form>';
}

function validate_form() {

    global $db;

    $errors = array();

    // Some sample usernames and passwords
    /*$users = array('alice'   => 'dog123',
                   'bob'     => 'my^pwd',
                   'charlie' => '**fun**');*/

    /*$users = array('alice'   => '$1$rasmusle$6IB4LK6olusfciGGKSDAJ/',
                   'bob'     => '$1$rasmusle$tsfgBLqGLclawiIpWmhyr.',
                   'charlie' => '$1$rasmusle$WmmxbNYGkNmARkTfap19M1');*/
    
    // Make sure user name is valid
    /*if (! array_key_exists($_POST['username'], $users)) {
        $errors[] = 'Please enter a valid username and password.';
    }else{*/
        // See if password is correct
        //$saved_password = $users[ $_POST['username'] ];

        $sth = $db->prepare('select password from users WHERE username = ?');
        $result = $sth->execute(array($_POST['username']));
        $saved_password = $result->fetchOne();

        var_dump($saved_password);
        var_dump($_POST['password']);
        var_dump(crypt($_POST['password'], $saved_password));

        //if ($saved_password != $_POST['password']) {
        if ($saved_password != crypt($_POST['password'], $saved_password)) {
            $errors[] = 'Please enter a valid username and password.';
        }
    //}

    return $errors;
}


function process_form() {
    // Add the username to the session
    $_SESSION['username'] = $_POST['username'];

    print "Welcome, $_SESSION[username]";
}
?>