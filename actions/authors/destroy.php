<?php
if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === "GET") {
    $id = $_GET['id'];

    echo "Penulis dengan id " . htmlspecialchars($id) . " berhasil dihapus.";
}

?>
