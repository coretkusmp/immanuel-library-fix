<?php
if (isset($_POST['update']) && $_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $isbn = $_POST['isbn'];
    $year = $_POST['year'];
    $stock = $_POST['stock'];
    $categoryId = $_POST['category_id'];
    $description = $_POST['description'];
    $authorIds = isset($_POST['author_ids']) ? $_POST['author_ids'] : [];

    print_r($_POST);
}

?>
