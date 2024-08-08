<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<!-- <link rel="stylesheet" href="css/main.css" /> -->
<!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
<style>div{padding: 10px;font-size:16px;}</style>
<title>ログイン</title>
</head>
<body>

<header>
<?php include("style.php");?>
  <div class="inner">
    <p>H_</p>
    <ul class="navi">
      <li><a class="navbar-brand" href="user.php">ユーザー登録</a><var></li>
    </ul>
  </div>
</header>

<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
<div class="main">
  <div class="jumbotron">
    <fieldset>ログイン
      <form name="form1" action="login_act.php" method="post">
        <table>
          <tr>
            <td>ID:</td>
            <td><input type="text" name="lid"></td>
          </tr>
          <tr>
            <td>PW:</td>
            <td><input type="password" name="lpw"></td>
          </tr>
        </table>
        <input type="submit" value="ログイン" class="subBtn">
      </form>
    </fieldset>
  </div>
</div>


</body>
</html>
