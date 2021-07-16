<?php
session_start();

require 'validation.php'; //読み込み

header('X-FRAME-OPTIONS:DENY'); //クリックジャグリング対策


if(!empty($_POST)){
  echo '<pre>';
  var_dump ($_POST);
  echo '<pre>';
}

function h($str){
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); //サニタイズ
}

$pageFrag =0;

$errors = validation($_POST);

if(!empty($_POST['btn_confirm']) && empty($errors)){
  $pageFrag = 1;
}

if(!empty($_POST['btn_submit'])){
  $pageFrag = 2;
}

?>

<!doctype html>
<html lang="ja">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
<body>

<!-- -------------------pageFrag = 0 ------------------- -->
<?php if($pageFrag === 0) : ?>

  <?php
    if(!isset($_SESSION['csrfToken'])){         //csrf対策
      $csrfToken = bin2hex(random_bytes(32));
      $_SESSION['csrfToken'] = $csrfToken;
    }
    $token = $_SESSION['csrfToken'];
  ?>

  <!-- エラーが空でなくて && btn_confirmが押されていたら エラーをリストで表示していく-->
  <?php if(!empty($errors) && !empty($_POST['btn_confirm']) ) : ?>
    <?php echo '<ul>' ; ?>
    <?php
      foreach($errors as $error){
        echo '<li>' . $error . '</li>' ;
      }
    ?>
    <?php echo '</ul>' ; ?>
  <?php endif ;?>

<div class="container"> <!--Bootstrapの準備 -->
  <div class="row">
    <div class="col-md-6">
      <form method="POST" action="input.php">
        <div class="from-group">
          <label for="your_name">氏名</label>
          <input type="text" name="your_name" class="form-control" id="your_name" value="<?php if(!empty($_POST['your_name'])){echo h($_POST['your_name']) ;}?>"required>
        </div>

        <div class="from-group">
        <label for="email">メールアドレス</label>
        <input type="email" name="email" class="form-control" id="email" value="<?php if(!empty($_POST['email'])){echo h($_POST['email']) ;}?>"required>
        </div>

        <div class="from-group">
        <label for="url">ホームページ</label>
        <input type="url" name="url" class="form-control" id="url" value="<?php if(!empty($_POST['url'])){echo h($_POST['url']) ;}?>">
        <div>

        性別
        <div class="form-check form-check-inline">
          <input type="radio" name="gender" class="form-check-input" id="gender1"  value="0"
          <?php if(isset($_POST['gender']) && $_POST['gender'] === '0'){echo 'checked'; } ?>>
          <label class="form-check-label" for="gender1">男性</label>

          <input type="radio" name="gender" class="form-check-input" id="gender2" value="1"
          <?php if(isset($_POST['gender']) && $_POST['gender'] === '1'){echo 'checked'; } ?>>
          <label class="form-check-label" for="gender2">女性</label>
        </div>

        <div class="form-group">
          <label for="age">年齢</label>
          <select class="form-control" id="age" name="age">
            <option value="">年齢を選択してください</option>
            <option value="1" selected>~19歳</option>
            <option value="2">20~29歳</option>
            <option value="3">30~39歳</option>
            <option value="4">40~49歳</option>
            <option value="5">50~59歳</option>
            <option value="6">60歳~</option>
          </select>
        </div>

        <div class="form-group">
          <label for="contact">お問い合わせ内容</label>
          <!-- row表示する行数 -->
          <textarea class="form-control" id="contact" name="contact" rows="3">
          <?php if(!empty($_POST['contact'])){echo h($_POST['contact']); } ?>
          </textarea>
        </div>

        <div class="form-check">
        <input class="form-check-input" id="caution" type="checkbox" name="caution" value="1" >
        <label class="form-check-label" for="caution">注意事項にチェックしてください</label>
        </div>

        <input class="btn btn-danger" type="submit" name="btn_confirm" value="確認する">
        <input type="hidden" name="csrf" value="<?php echo $token; ?>">
      </form>
    </div><!-- .col-md-6(Bootstrap終了) -->
  </div>
</div>
<?php endif; ?>

<!-- -------------------pageFrag = 1 ------------------- -->
<?php if($pageFrag === 1) : ?>
  <?php if($_POST['csrf'] === $_SESSION['csrfToken']): ?>

    <form method="POST" action="input.php">
      あなたの名前
      <?php echo h($_POST["your_name"]) ;?>
      <br>
      メールアドレス
      <?php echo h($_POST["email"]) ;?>
      <br>
      ホームページ
      <?php echo h($_POST["url"]) ;?>
      <br>
      性別
      <?php
        if($_POST['gender'] === '0'){echo '男性';}
        if($_POST['gender'] === '1'){echo '女性';}
      ?>
      <br>
      年齢
      <?php
      if($_POST['age'] === '1'){echo '~19歳';}
      if($_POST['age'] === '2'){echo '20~29歳';}
      if($_POST['age'] === '3'){echo '30~39歳';}
      if($_POST['age'] === '4'){echo '40~49歳';}
      if($_POST['age'] === '5'){echo '50~59歳';}
      if($_POST['age'] === '6'){echo '60歳~';}
      ?>

      ?>
      <br>
      お問い合わせ内容
      <?php echo h($_POST["contact"]) ;?>
      <br>
      <input type="submit" name="back" value="戻る">
      <input type="submit" name="btn_submit" value="送信する">
      <input type="hidden" name="your_name" value="<?php echo h($_POST['your_name']) ;?>">
      <input type="hidden" name="email" value="<?php echo h($_POST['email']) ;?>">
      <input type="hidden" name="url" value="<?php echo h($_POST['url']) ;?>">
      <input type="hidden" name="gender" value="<?php echo h($_POST['gender']) ;?>">
      <input type="hidden" name="age" value="<?php echo h($_POST['age']) ;?>">
      <input type="hidden" name="contact" value="<?php echo h($_POST['contact']) ;?>">
      <input type="hidden" name="csrf" value="<?php echo h($_POST['csrf']) ;?>">
    </form>

  <?php endif; ?>
<?php endif; ?>

<!-- -------------------pageFrag = 2 ------------------- -->
<?php if($pageFrag === 2) : ?>
  <?php if($_POST['csrf'] === $_SESSION['csrfToken']): ?>

  <!-- DB接続 -->
  <!-- DB保存 -->
  <?php require '../mainte/insert.php';

    insertContact($_POST);
  ?>



  送信が完了しました。
  <?php unset($_SESSION['csrfToken']); ?>

  <?php endif; ?>
<?php endif; ?>



<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body></html>


