<?php
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $stmt = db_prepare($koneksi, "DELETE FROM jadwal WHERE id = ?");
    db_stmt_bind_param($stmt, 'i', $id);
    db_stmt_execute($stmt);
}
header('Location: layout.php?page=jadwal&sukses=hapus');
exit;
