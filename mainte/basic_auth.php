<?php
// .htaccessはアクセス制限がかかるのであらかじめ必要な情報を記録しておく
// 必要な情報が 2つある
// 1パスワードを記録したファイルの場所
echo __FILE__;
// /Applications/MAMP/htdocs/test0503/mainte/test.php

// 2パスワード（暗号化） crypt関数 と password_hash関数がある php7からは password_hashが推奨
//password_hash関数には PASSWORD_DEFAULT と PASSWORD_BCRYPTがある
echo '<br>';
echo(password_hash('password123', PASSWORD_BCRYPT));
?>