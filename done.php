<?php
  //データベースに接続する
  $cn = mysqli_connect('localhost', 'root', '', 'ph22');
  //文字コードをセット
  mysqli_set_charset($cn, 'utf8');
  //SQLを指定
  $sql = "SELECT id,name FROM task2";
  $result = mysqli_query($cn, $sql);
  //中身を取り出す
  while ($row = mysqli_fetch_assoc($result)) {
    $display[] = $row;
  }
  //データベースを切断
  mysqli_close($cn);
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
        <tr>
          <td>氏名</td>
        </tr>
        <?php foreach ($display as $val) : ?>
          <tr>
            <td><a href="details.php?id=<?php echo $val['id'] ?>"><?php echo $val['name'] ?></a></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>