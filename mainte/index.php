<?php

require 'db_connection.php';

//DBのデータを取得するためにSQL文をうつ。方法は大きく2つ
//ユーザー入力なし query(関数)1つでかける
$sql = 'select * from contacts where id = 2';//sql
$stmt = $pdo->query($sql);//sql実行 ステートメント

$result = $stmt->fetchall();

echo '<pre>';
var_dump($result);
echo '</pre>';

//ユーザー入力あり prepare, bind, execute(関数)3つで書く （お問い合わせフォームなどでユーザーの入力がある場合）
//悪意のあるユーザーにdelete *を使われて全部データが消えると困るので3つのメソッドを使ってSQLインジェクション対策を行う
$sql = 'select * from contacts where id = :id';//名前付きプレースホルダー
$stmt = $pdo->prepare($sql);//プリペアードステイトメント
$stmt->bindValue('id', 1, PDO::PARAM_INT);//紐付け
$stmt->execute();//実行

$result = $stmt->fetchall();

echo '<pre>';
var_dump($result);
echo '</pre>';


//トランザクション まとまって処理 beginTransaction, commit, rollback
//銀行で送金が片側だけ処理されてないとやばいよねって話

$pdo->beginTransaction();//トランザクション開始の合図

try{
//sql処理
  $stmt = $pdo->prepare($sql);//プリペアードステイトメント
  $stmt->bindValue('id', 1, PDO::PARAM_INT);//紐付け
  $stmt->execute();//実行

  $pdo->commit();//全てまとめて処理をする

}catch(PDOException $e){
  $pdo->rollback();//更新のキャンセル
}
