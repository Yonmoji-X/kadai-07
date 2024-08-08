<?php
session_start();
include("funcs.php");
sschk();

// POSTデータ取得
$admin_or_emp = $_POST['admin_or_emp'];
$work_in_or_out = $_POST['work_in_or_out'];
$recorder = $_POST['recorder'];
$auth_id= $_POST["auth_id"];

// データベース接続
$pdo = db_conn();

// ファイルのアップロードがあるかチェック
function get_file_content($file) {
    if (isset($file) && $file['error'] == UPLOAD_ERR_OK) {
        return file_get_contents($file['tmp_name']);
    }
    return null;
}

// 現在日時取得
$indate = date('Y-m-d H:i:s');

// データ挿入処理
foreach ($_POST as $key => $value) {
    if (strpos($key, 'title_') === 0) {
        $index = str_replace('title_', '', $key);
        $title = $value;
        $check_item = isset($_POST["check_item_$index"]) ? $_POST["check_item_$index"] : null;
        $text = isset($_POST["text_$index"]) ? $_POST["text_$index"] : null;
        $photo = isset($_FILES["photo_$index"]) ? get_file_content($_FILES["photo_$index"]) : null;
        $temp = isset($_POST["temp_$index"]) ? $_POST["temp_$index"] : null;

        // データ挿入SQL作成
        $sql = "INSERT INTO H_record_table (admin_or_emp, work_in_or_out, title, recorder, check_item, text, photo, temp, indate, auth_id)
                VALUES (:admin_or_emp, :work_in_or_out, :title, :recorder, :check_item, :text, :photo, :temp, :indate, :auth_id)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':admin_or_emp', $admin_or_emp, PDO::PARAM_INT);
        $stmt->bindValue(':work_in_or_out', $work_in_or_out, PDO::PARAM_INT);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':recorder', $recorder, PDO::PARAM_INT);
        $stmt->bindValue(':check_item', $check_item, PDO::PARAM_STR);
        $stmt->bindValue(':text', $text, PDO::PARAM_STR);
        $stmt->bindValue(':photo', $photo, PDO::PARAM_LOB); // BLOB型として設定
        $stmt->bindValue(':temp', $temp, PDO::PARAM_INT);
        $stmt->bindValue(':indate', $indate, PDO::PARAM_STR);
        $stmt->bindValue(':auth_id', $auth_id, PDO::PARAM_INT);
        $status = $stmt->execute();

        if ($status === false) {
            $error = $stmt->errorInfo();
            echo "SQLエラー: " . $error[2];
            exit;
        }
    }
}

// ========================勤怠管理=========================

// 出勤時の処理
if ((int)$work_in_or_out === 1 && (int)$admin_or_emp === 0) { // 確実に整数で比較
    $date = date('Y-m-d');
    $clock_in = date('H:i:s');

    // データ登録SQL作成
    $sql_attndnc = "INSERT INTO H_attendance_table (mmbr_id, date, clock_in, auth_id) VALUES (:mmbr_id, :date, :clock_in, :auth_id)";
    $stmt_attndnc = $pdo->prepare($sql_attndnc);
    $stmt_attndnc->bindValue(':mmbr_id', $recorder, PDO::PARAM_INT);
    $stmt_attndnc->bindValue(':date', $date, PDO::PARAM_STR);
    $stmt_attndnc->bindValue(':clock_in', $clock_in, PDO::PARAM_STR);
    $stmt_attndnc->bindValue(':auth_id', $auth_id, PDO::PARAM_INT);
    $status_attndnc = $stmt_attndnc->execute();

    if ($status_attndnc === false) {
        $error = $stmt_attndnc->errorInfo();
        echo "SQLエラー: " . $error[2];
        exit;
    }
}

// 退勤時の処理
if ((int)$work_in_or_out === 0) { // 確実に整数で比較
// if ((int)$work_in_or_out === 0  && (int)$admin_or_emp === 0) { // 確実に整数で比較
    $date = date('Y-m-d');
    $clock_out = date('H:i:s');

    // 対応するレコードの更新
    // $sql_attndnc_out = "UPDATE H_attendance_table SET clock_out = :clock_out WHERE mmbr_id = :mmbr_id AND date = :date AND clock_out IS NULL AND auth_id = :auth_id";
    $sql_attndnc_out = "UPDATE H_attendance_table
        SET clock_out = :clock_out
        WHERE id = (
        SELECT id FROM H_attendance_table
        WHERE mmbr_id = :mmbr_id
        AND date = :date
        AND clock_out IS NULL
        AND auth_id = :auth_id
        ORDER BY id DESC
        LIMIT 1
    )
";
    $stmt_attndnc_out = $pdo->prepare($sql_attndnc_out);
    $stmt_attndnc_out->bindValue(':clock_out', $clock_out, PDO::PARAM_STR);
    $stmt_attndnc_out->bindValue(':mmbr_id', $recorder, PDO::PARAM_INT);
    $stmt_attndnc_out->bindValue(':date', $date, PDO::PARAM_STR);
    $stmt_attndnc_out->bindValue(':auth_id', $auth_id, PDO::PARAM_INT);
    $status_attndnc_out = $stmt_attndnc_out->execute();

    if ($status_attndnc_out === false) {
        $error = $stmt_attndnc_out->errorInfo();
        echo "SQLエラー: " . $error[2];
        exit;
    }
}
// =========================================================

redirect('rcrd_select.php');
?>
