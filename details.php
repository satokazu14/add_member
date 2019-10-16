<?php
  //データベースに接続する
  $cn = mysqli_connect('localhost', 'root', '', 'ph22');
  //文字コードをセット
  mysqli_set_charset($cn, 'utf8');
  //SQLを指定
  $sql = "SELECT name,login_id,pass,email FROM task2 WHERE id = " . $_GET['id'] . "";
  $result = mysqli_query($cn, $sql);
  //中身を取り出す
  $row = mysqli_fetch_assoc($result);
  //データベースを切断
  mysqli_close($cn);
  //表示する様の配列
  $display = [
    ['item' => '名前', 'val' => $row['name'],],
    ['item' => 'ログインID', 'val' => $row['login_id'],],
    ['item' => 'パスワード', 'val' => $row['pass'],],
    ['item' => 'メール', 'val' => $row['email'],],
  ]
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/style.css" rel="stylesheet" type="text/css">
  <title>完了画面</title>
</head>

<body>
  <div class="container col-6">
    <table class="table table-bordered mt-4">
      <tbody>
        <?php foreach ($display as $val) : ?>
          <tr>
            <td><?php echo $val['item'] ?></td>
            <td><?php echo $val['val'] ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <a href="done.php"><button class="btn btn-default border mb-2" name="back">戻る</button></a>
  </div>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>