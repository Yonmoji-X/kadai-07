<?php
session_start();
//※htdocsと同じ階層に「includes」を作成してfuncs.phpを入れましょう！
//include "../../includes/funcs.php";
include "funcs.php";
// sschk();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>USERデータ登録</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <style>
    div{padding: 10px;font-size:16px;}
  </style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <?php include("style.php");?>
      <div class="inner">
        <p>H_</p>
        <ul class="navi">
          <li><a class="button" href="login.php">ログイン</a><var></li>
        </ul>
      </div>
</header>

<!-- Head[End] -->

<!-- Main[Start] -->
<div class="main">
  <form method="post" action="user_insert.php">
    <div class="jumbotron">
     <fieldset>
      <table>
        <tr>
          <td>名前：</td>
          <td><input type="text" name="name"></td>
        </tr>
        <tr>
          <td>Login ID：</td>
          <td><input type="text" name="lid"></td>
        </tr>
        <tr>
          <td>Login PW：</td>
          <td><input type="text" name="lpw"></td>
        </tr>
        <tr>
          <td>管理FLG：</td>
          <td>
          一般<input type="radio" name="kanri_flg" value="0">
        管理者<input type="radio" name="kanri_flg" value="1">
          </td>
        </tr>
      </table>
      <legend>ユーザー登録</legend>

       <input type="submit" value="登録" class="subBtn">
      </fieldset>
    </div>
  </form>
  <!-- Main[End] -->
</div>


</body>
</html>
