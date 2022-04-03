<?php
//DBに接続する
  try {
      $pdo = new PDO('mysql:dbname=looney_db;charset=utf8;host=localhost;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock','root','root');
  } catch (PDOException $e) {
      exit('DBError:'.$e->getMessage());
  }

  //SQL分を作成する
  $sql = "SELECT * FROM dvd_list, dvd_episode, old_shortfilm_list WHERE dvd_list.jan = dvd_episode.jan AND old_shortfilm_list.title_id = dvd_episode.title_id ORDER BY dvd_episode.episode_number ASC;";
  $stmt = $pdo->prepare($sql);
  $status = $stmt->execute();
  
  //データの表示
  if ($status==false) {
      //execute（SQL実行時にエラーがある場合）
      $error = $stmt->errorInfo();
      exit("SQLError:".$error[2]);
  } else {
      //Selectデータで取得したレコードの数だけ自動でループする
      while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //配列に格納
        $data[] = $res;
      }
  }
  
  //JSON形式にして出力
  //JSON_UNESCAPED_UNICODE：マルチバイト文字をそのまま扱う(文字化けしないようにする)
  header("Access-Control-Allow-Origin: *");
  echo json_encode($data, JSON_UNESCAPED_UNICODE);
  print_r($res);