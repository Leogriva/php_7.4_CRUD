<?php

$contactFile = '.contact.dat';

//ファイル丸ごと読み込み
$fileContents = file_get_contents($contactFile);

// echo $fileContents;

//ファイルに書き込み（上書き）
// file_put_contents($contactFile, 'テストです');

$addText = 'テストです' . "\n" ;

//ファイルに書きこみ（追記）
file_put_contents($contactFile, $addText, FILE_APPEND);

