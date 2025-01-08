<?php

//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。

//1-1. POSTデータ取得
$name   = $_POST['name'];
$email  = $_POST['email'];

//1-2. $id = $_POST["id"]を追加
$id = $_POST['id'];

//2. DB接続します
//*** function化する！  *****************
require_once('funcs.php');
$pdo = db_conn();

//３．データ登録SQL作成
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加

$stmt = $pdo->prepare('UPDATE 
                            kadai_php3_table
                        SET 
                            name = :name, 
                            email = :email,
                            indate = sysdate()
                        WHERE
                            id = :id;
                        ');

// 数値の場合 PDO::PARAM_INT
// 文字の場合 PDO::PARAM_STR
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute(); //実行

//４．データ登録処理後
//4. header関数"Location"を「select.php」に変更
if ($status === false) {
    //*** function化する！******\
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    //*** function化する！*****************
    header('Location: select.php');
    exit();
}




