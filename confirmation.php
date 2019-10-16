<?php
  session_start();
  //登録ボタンを押した場合
  if (isset($_POST['submit'])) {
    //データベースに接続する
    $cn = mysqli_connect('localhost', 'root', '', 'ph22');
    //文字コードをセット
    mysqli_set_charset($cn, 'utf8');
    //SQLを指定
    $sql = "INSERT INTO task2(id,name,login_id,pass,email) VALUES('','" . $_SESSION['name'] . "','" . $_SESSION['login_id'] . "','" . $_SESSION['pass'] . "','" . $_SESSION['email'] . "')";
    //SQLを実行
    mysqli_query($cn, $sql);
    //データベースを切断
    mysqli_close($cn);
    session_destroy();
    header('location: done.php');
    exit();
  }

  //戻るボタンを押した場合
  if (isset($_POST['back'])) {
    $_SESSION['back'] = 'back';
    header('location: index.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <title>確認画面</title>
</head>

<body>
  <div class="container col-6">
    <table class="table table-bordered">
      <tbody>
        <?php foreach ($_SESSION as $key => $val) : ?>
          <tr>
            <td><?php echo $key ?></td>
            <td><?php echo $val ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <form method="post" action="">
      <button class="btn btn-default border mb-2" name="back">戻る</button>
      <button class="btn btn-default border mb-2" name="submit">登録</button>
    </form>
  </div>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>