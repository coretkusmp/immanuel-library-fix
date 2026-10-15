<?php
if (isset($_POST['store']) && $_SERVER['REQUEST_METHOD'] === "POST") {
    $name = $_POST['name'];
    $bio = $_POST['bio'];

    print_r($_POST);
}

?>
