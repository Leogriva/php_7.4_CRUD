<?php

function validation($request){ //フォームの入力内容 $_POST連想配列が入ってくる

    $errors = []; //エラーをまとめて保管するために配列を作っておく
                  //ローカル変数なので外側からアクセスできない

    if(empty($request['your_name']) || 20 < mb_strlen($request['your_name'])){
      $errors[] = '氏名は必須です。20文字以内で入力してください。'; //[]をつけることで配列に値をつけることができる
    }

    if(empty($request['email']) || !filter_var($request['email'], FILTER_VALIDATE_EMAIL) ){
      $errors [] = 'メールアドレスは必須です。正しい形式で入力して下さい';
    }

    if(!empty($request['url'] )){
      if(!filter_var($request['url'], FILTER_VALIDATE_URL)){
        $errors[] = 'ホームページは正しい形式で入力してください';
      }
    }

    if(!isset($request['gender'])){ //emptyだと0が通ってしまうのでissetを使う
      $errors[] = '「性別」は必須です。';
    }

    if(empty($request['age']) || 6 < $request['age']){
      $errors[] = '年齢は必須です。';
    }

    if(empty($request['contact']) || 200 < mb_strlen($request['contact'])){
      $errors[] = 'お問い合わせ内容は必須です。200文字以内で入力してください。';
    }

    if(empty($request['caution'])){
      $errors[] = '「注意事項」をご確認ください。';
    }

    return $errors;
}

?>