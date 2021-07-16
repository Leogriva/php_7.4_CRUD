<?php
//DB接続  PDO
function insertContact($request){

require 'db_connection.php';

//入力 DB保存 prepare,execute（配列（全て文字列なのでbindなしで配列で対応できる））

$params = [
  'id' => null,//何もないという意味 オートインクリメントで入ってくるから
  'your_name' => $request['your_name'],
  'email' => $request['email'],
  'url' => $request['url'],
  'gender' => $request['gender'],
  'age' => $request['age'],
  'contact' => $request['contact'],
  'created_at' => null
];

$count = 0;
$columns = '';
$values = '';

foreach(array_keys($params) as $key){
  if($count++>0){
    $columns .= ',';
    $values .= ',';
  }
  $columns .= $key;
  $values .= ':'.$key;
}
$sql = 'insert into contacts ('. $columns .')values('. $values .') ';//名前付きプレースホルダー

$stmt = $pdo->prepare($sql);//プリペアードステイトメント
$stmt->execute($params);//実行
}