<?php
session_start();

$id = $_GET["id"]; //?id~**を受け取る
include("funcs.php");
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM H_member_table WHERE id=:id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if($status==false) {
    sql_error($stmt);
}else{
    $row = $stmt->fetch();
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
<?php include("menu.php");?>
  <!-- <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav> -->
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<!-- <form method="POST" action="member_update.php"> -->
  <div class="main">
    <div class="jumbotron">
      <h3>従業員詳細</h3>
      <table>
        <tr>
          <td>名前：</td>
          <td><?=$row["name"]?></td>
        </tr>
        <tr>
          <td>メール：</td>
          <td><?=$row["email"]?></td>
        </tr>
        <tr>
          <td>情報：</td>
          <td><?=$row["content"]?></td>
        </tr>
      </table>
    </div>
    <!-- <legend>[詳細]</legend> -->
  </div>


</body>
</html>
