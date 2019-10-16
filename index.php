<?php
  session_start();
  //各項目に空白を代入
  $name     = '';
  $login_id = '';
  $pass     = '';
  $email    = '';

  //各エラーメッセージに空白を代入
  $err_msg['name']     = '';
  $err_msg['login_id'] = '';
  $err_msg['pass']     = '';
  $err_msg['email']    = '';

  //次へボタンを押した場合
  if (isset($_POST['submit'])) {
    //htmlspecialcharsで特殊文字をエスケープ
    $name     = htmlspecialchars($_POST['name'], ENT_QUOTES);
    $login_id = htmlspecialchars($_POST['login_id'], ENT_QUOTES);
    $pass     = htmlspecialchars($_POST['pass'], ENT_QUOTES);
    $email    = htmlspecialchars($_POST['email'], ENT_QUOTES);

    //nameのエラーチェック
    if (empty($name)) {
      $err_msg['name'] = 'nameが入力されていません';
    } elseif (mb_strlen($name) > 30) {
      $err_msg['name'] = 'nameは30文字以内で入力して下さい';
    }

    //login_idのエラーチェック
    if (empty($login_id)) {
      $err_msg['login_id'] = 'login_idが入力されていません';
    } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $login_id)) {
      $err_msg['login_id'] = 'login_idは半角英数で入力して下さい';
    } elseif (strlen($login_id) < 3) {
      $err_msg['login_id'] = 'login_idは3文字以上で入力して下さい';
    } elseif (strlen($login_id) > 30) {
      $err_msg['login_id'] = 'login_idは30文字以内で入力して下さい';
    } else {
      //データベースに接続する
      $cn = mysqli_connect('localhost', 'root', '', 'ph22');
      //文字コードをセット
      mysqli_set_charset($cn, 'utf8');
      //SQLを指定
      $sql = "SELECT id FROM task2 WHERE login_id LIKE '$login_id'";
      $result = mysqli_query($cn, $sql);
      //重複チェック
      if ($row = mysqli_fetch_assoc($result)) {
        $err_msg['login_id'] = 'そのlogin_idは既に使用されています';
      }
      //データベースを切断
      mysqli_close($cn);
    }

    //passwordのエラーチェック
    if (empty($pass)) {
      $err_msg['pass'] = 'passwordが入力されていません';
    } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $pass)) {
      $err_msg['pass'] = 'passwordは半角英数で入力して下さい';
    } elseif (strlen($pass) < 6) {
      $err_msg['pass'] = 'passwordは6文字以上で入力して下さい';
    } elseif (strlen($pass) > 30) {
      $err_msg['pass'] = 'passwordは30文字以内で入力して下さい';
    }

    //emailのエラーチェック
    if (empty($email)) {
      $err_msg['email'] = 'emailが入力されていません';
    } elseif (strpos($email, '@docomo.ne.jp') !== false || strpos($email, '@ezweb.ne.jp') !== false) {
      if (!preg_match("/^([a-zA-Z])+([a-zA-Z0-9\._-])*@(docomo\.ne\.jp|ezweb\.ne\.jp)$/", $email)) {
        $err_msg['email'] = 'emailの形式が正しくありません';
      }
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      $err_msg['email'] = 'emailの形式が正しくありません';
    }

    //エラーメッセージが一つも出ていない場合
    if (array_search(!'', $err_msg) === false) {
      //SESSIONに入力された値を代入
      $_SESSION = [
        'name'     => $name,
        'login_id' => $login_id,
        'pass'     => $pass,
        'email'    => $email,
      ];
      header('location: confirmation.php');
      exit();
    }
  }

  //次のページから戻ってきた場合
  if (!empty($_SESSION['back'])) {
    $name     = $_SESSION['name'];
    $login_id = $_SESSION['login_id'];
    $email    = $_SESSION['email'];
    session_destroy();
  }

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <title>登録画面</title>
</head>

<body>
  <div class="container border mt-4 col-5">
    <form action="" method="post">
      <div class="form-group">
        <label class="mt-1">name:</label>
        <input type="text" name="name" class="form-control" value="<?php echo $name ?>" placeholder="30文字以内">
        <span class="err_msg"><?php echo $err_msg['name'] ?></span>
      </div>
      <div class="form-group">
        <label>login_id:</label>
        <input type="text" name="login_id" class="form-control" value="<?php echo $login_id ?>" placeholder="半角英数3文字以上30文字以内">
        <span class="err_msg"><?php echo $err_msg['login_id'] ?></span>
      </div>
      <div class="form-group">
        <label>password:</label>
        <input type="password" name="pass" class="form-control" value="" placeholder="半角英数6文字以上30文字以内">
        <span class="err_msg"><?php echo $err_msg['pass'] ?></span>
      </div>
      <div class="form-group">
        <label>email:</label>
        <input type="text" name="email" class="form-control" value="<?php echo $email ?>" placeholder="@必須">
        <span class="err_msg"><?php echo $err_msg['email'] ?></span>
      </div>
      <button class="btn btn-default border mt-2 mb-2" type="submit" name="submit">次へ</button>
    </form>
  </div>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>