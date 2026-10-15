<?php
if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === "GET") {
    $id = $_GET['id'];

    echo "Pengguna dengan id " . htmlspecialchars($id) . " berhasil dihapus.";
}

?>
