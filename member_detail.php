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
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<div class="main">
  <form method="POST" action="member_update.php">
    <div class="jumbotron">
     <fieldset>
      <table>
        <tr>
          <td>名前：</td>
          <td><input type="text" name="name" value="<?=$row["name"]?>"></td>
        </tr>
        <tr>
          <td>Email：</td>
          <td><input type="text" name="email" value="<?=$row["email"]?>"></td>
        </tr>
        <tr>
          <td>詳細情報</td>
          <td><textArea name="content" rows="4" cols="40"><?=$row["content"]?></textArea></td>
        </tr>
      </table>
       <input type="submit" value="送信" class="subBtn">
       <input type="hidden" name="id" value="<?=$id?>">
      </fieldset>
    </div>
  </form>
  <!-- Main[End] -->
</div>


</body>
</html>
