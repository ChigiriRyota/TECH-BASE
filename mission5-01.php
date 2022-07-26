<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>mission5-01.php</title>
  <p>パスワード：tech-base</p>
</head>
<body>
  <?php
// DB接続設定
    // $dsn = 'mysql:dbname=tb240084db;host=localhost';
    // $user = 'tb-240084';
    // $password = 'HkS92SXE4z';
    $dsn = 'データベース名'
    $user = 'ユーザー名'
    $password = 'パスワード'
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    error_reporting(E_ALL & ~E_NOTICE);

    // 今回はテキストファイルに格納するのではなく、dbに格納
    // $file_name = "mission_3-5.txt";
    // $fp = fopen($file_name, "a");
    $password = "tech-base";

  ?>

  <form action="" method="POST">
    <p>編集番号　：<input type="text" name="edit" value=""></p>
    <p>パスワード：<input type="password" name="e_pass"></p>
    <?php
      $na = "";
      $comm = "";
      $e_number = 0;
      
    //   $comments = file($file_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    //   データベースと編集したい番号
      $sql ='SELECT * FROM bulletinboard';
      $result = $pdo -> query($sql);
    //   foreach ($result as $row){
    //     echo $row[1];
    //   }
        // echo "<hr>";
      if(!empty($_POST["edit"]) && $password == $_POST["e_pass"]){
        $e_number = $_POST["edit"];
      
        foreach($result as $comment) {
            // データベースには","区切りで入力されるため。
        //   $splits = explode(',', $comment);
          if($comment[0] == $e_number) {  
            $na = $comment[1];
            $comm = $comment[2];
            break 1;
          }
        }
      }

    ?>
    <p> <input type="hidden" name="judge" value = "<?php if($e_number != 0) echo $e_number; ?>" > </p>
    <p>名前　　　：<input type="text" name="name" value = "<?php echo $na; ?>" > </p>
    <p>コメント　：<input type="text" name="comment" value = "<?php echo $comm; ?>" > </p>
    <p>パスワード：<input type="password" name="comme_pass"></p>

    <p>削除番号　：<input type="text" name="delete" value=""> </p>
    <p>パスワード：<input type="password" name="delete_pass"> <input type="submit" value="送信"></p>
  </form>

  <hr>

  <?php
//  　 error_reporting(E_ALL & ~E_NOTICE);
    if(!empty($_POST["judge"]) ) { //編集
    //   $comments = file($file_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $sql = 'UPDATE bulletinboard SET name=:name,comment=:comment WHERE id=:id';
      $sql2 ='SELECT * FROM bulletinboard';
      $result = $pdo -> query($sql2);
    //   $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    //   $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    //   $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //   $stmt->execute();
      $when = date('Y年m月d日 H時i分s秒')."にコメントを受け付けました<br/>";
      $order = 0;
      foreach($result as $comme){
        // $split = explode(",",$comme);
        
        if($_POST["judge"] == $comme[0]){
          $when = date('Y年m月d日 H時i分s秒')."にコメントを受け付けました<br/>";
        //   $stmts[$order] = $_POST["judge"]. ",". $_POST["name"]. ",". $_POST["comment"];
          $stmt = $pdo->prepare($sql);
        //   $stmt = $pdo -> prepare("INSERT INTO bulletinboard (name, comment) VALUES (:name, :comment)");
          $stmt -> bindParam(':name', $_POST["name"], PDO::PARAM_STR);
          $stmt -> bindParam(':comment', $_POST["comment"], PDO::PARAM_STR);
          $stmt->bindParam(':id', $_POST["judge"], PDO::PARAM_INT);
          $stmt -> execute();
          
          break 1;
        }
        $order++;
      }
      
    //   $order =  0;

    }
    elseif(!empty($_POST["name"]) && !empty($_POST["comment"]) && $password == $_POST["comme_pass"]){ //コメントの追加
    //   $comments = file($file_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $sql ='SELECT * FROM bulletinboard';
      $result = $pdo -> query($sql);
      
    //   sqlは追加する際にidをいちいち指定する必要がないはず
      $num = 0;
    //   $split = explode(",", $last_comment);
        foreach($result as $comme){
    // 　  $last_comment = $result[(count($result) - 1)];
    //     $last_number = $comme[0]; 
            $num += 1;
        }
      $when = date('Y年m月d日 H時i分s秒')."にコメントを受け付けました<br/>";
      $sql = $pdo -> prepare("INSERT INTO bulletinboard (name, comment) VALUES (:name, :comment)");
      
      $sql -> bindParam(':name', $_POST["name"], PDO::PARAM_STR);
      $sql -> bindParam(':comment', $_POST["comment"], PDO::PARAM_STR);
      $sql -> execute();
    }
    elseif(!empty($_POST["delete"]) && $password == $_POST["delete_pass"]) { //削除
    //   $comments = file($file_name, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); 
      $sql ='SELECT * FROM bulletinboard';
      $result = $pdo -> query($sql);
    //   ftruncate($fp, 0);
    //   fseek($fp, 0, SEEK_SET); 

      foreach($result as $comme) {
        // $splits = explode("<>", $comme);
        if($comme[0] == $_POST["delete"]) {
            // echo $comme[0];
            $id = $comme[0];
            // $id=$stmt->rowCount();
            $sql = 'delete from bulletinboard where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id',$id, PDO::PARAM_INT);
            $stmt->execute();
        //   fwrite($fp, $comme.PHP_EOL);
        }
        
      }
        
    }

    $sql = 'SELECT * FROM bulletinboard';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].'<br>';
        echo "<hr>";
    }
    // $comments = file($file_name);

    // foreach($comments as $comment) {
    //   $splits = explode("<>", $comment);
    //   for($i = 0; $i < count($splits); $i++) {
    //     echo $splits[$i]." ";
    //   }
    // }

    // fclose($fp);
  ?>
</body>
</html>
