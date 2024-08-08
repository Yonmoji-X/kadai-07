<?php
// check_gene_id.php

include("funcs.php");
$pdo = db_conn();

$gene_id = $_POST['gene_id'];

// `gene_id` が存在するかどうかをチェックするクエリ
$sql = "SELECT COUNT(*) FROM H_share_table WHERE gene_id = :gene_id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':gene_id', $gene_id, PDO::PARAM_INT);
$stmt->execute();

$count = $stmt->fetchColumn();

// 結果をJSON形式で返す
echo json_encode(['exists' => $count > 0]);
?>
