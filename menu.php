
<nav>
  <div class="inner">
    <p class="logo"><a class="over" href="rcrd_index.php">H_</a></p>
    <ul class="navi">
        <li>
            <a class="navbar-brand" href="tmplt_select.php">チェック項目一覧</a>
        </li>

        <?php if ($_SESSION["kanri_flg"] == "1"): ?>
            <li>
                <a class="navbar-brand" href="tmplt_index.php">[チェック項目登録]</a>
            </li>
        <?php endif; ?>
        <li>
            <a class="navbar-brand" href="member_select.php">従業員一覧</a>
        </li>
        <?php if ($_SESSION["kanri_flg"] == "1"): ?>
            <li>
                <a class="navbar-brand" href="member_index.php">[従業員登録]</a>
            </li>
        <?php endif; ?>
        <li>
            <a class="navbar-brand" href="rcrd_select.php">チェック一覧</a>
        </li>
        <li>
            <a class="navbar-brand" href="rcrd_index.php">[チェック]</a>
        </li>
        <li>
            <a class="navbar-brand" href="attndnc_select.php">勤怠管理</a>
        </li>
        <?php if ($_SESSION["kanri_flg"] == "1"): ?>
            <li>
                <a class="navbar-brand" href="shr_index.php">一般ユーザー登録</a>
            </li>
            <?php endif; ?>
            <?php if($_SESSION["kanri_flg"] == "0"){ ?>
                <li>管理者：<?= $auth_name ?></li>
            <?php } ?>
            <li>
                <?php if($_SESSION["kanri_flg"] == "0"){ ?>
                    <label>一般アカウント：</label><br>
                <?php } ?>
                <?php if($_SESSION["kanri_flg"] == "1"){ ?>
                    <label>管理アカウント：</label><br>
                <?php } ?>
                <?= htmlspecialchars($_SESSION["name"], ENT_QUOTES, 'UTF-8') ?>
            </li>
            <li>
                <a class="button"  href="logout.php">ログアウト</a>
            </li>

        </ul>
  </div>
  <button class="sp-navi-toggle"><span class="bar"></span><span class="bar"></span><span class="bar"></span><span class="menu">MENU</span><span class="close">CLOSE</span></button>
</nav>


<?php include("style.php");?>
