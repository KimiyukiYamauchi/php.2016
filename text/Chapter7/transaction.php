<?php
  require_once("function.php");
 
  try{
 
    $dbh = new PDO(DSN, USERNAME, PASSWORD);
 
    // 静的プレースホルダを指定
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 
    // エラー発生時に例外を投げる
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    //パラメータ
    $dish_name = 'カツカレー';
    $price = 5.25;
    $is_spicy = 1;
 
    //プリペアドステートメント
    $sql = "insert into dishes (dish_name, price, is_spicy) " .
              "values(?, ?, ?)";
//              "values(:dish_name, :price, :is_spicy)"
    $stmt = $dbh->prepare($sql);
 
    //トランザクション処理を開始
    $dbh->beginTransaction();
  
    try {
 
/*
      $stmt->bindParam(1, $dish_name, PDO::PARAM_STR);
      $stmt->bindParam(2, $price, PDO::PARAM_INT);
      $stmt->bindParam(1, $is_spicy, PDO::PARAM_INT);
*/
      $stmt->execute(array($dish_name, $price, $is_spicy));
 
      //コミット
      $dbh->commit();

      echo '正常に追加されました！';
      
    }catch(PDOException $e){
    
      //ロールバック
      $dbh->rollback();
 
      throw $e;
    }
 
  } catch(PDOException $e){
    echo $e->getMessage();
  }
 
?>