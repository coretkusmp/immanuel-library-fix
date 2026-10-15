<?php
require_once __DIR__ . "/../../config/database.php";

if (isset($_POST['store']) && $_SERVER['REQUEST_METHOD'] === "POST") {
   try{
      $pdo->beginTransaction();

      $title = htmlspecialchars($_POST['title']);
      $isbn = htmlspecialchars($_POST['isbn']);
      $year = htmlspecialchars($_POST['year']);
      $stock = htmlspecialchars($_POST['stock']);
      $description = htmlspecialchars($_POST['description']);
      $categoryId = htmlspecialchars($_POST['category_id']);

      $query = "insert into Books (title, isbn, year, stock, description, category_id) 
               values (:title, :isbn, :year, :stock, :description, :category_id)
               ";

      $stmt = $pdo->prepare($query);
      $stmt->execute([
         "title" => $title, 
         "isbn" => $isbn, 
         "year" => $year, 
         "stock" => $stock, 
         "description" => $description, 
         "category_id" => $categoryId, 
      ]);



      $bookId = $pdo->lastInsertId();

      $query = "insert into book_author (book_id, author_id)
               values (:book_id, :author_id)";

      $stmt = $pdo->prepare($query);

      $authorIds = $_POST["author_ids"];
      foreach($authorIds as $authorId){
         $stmt->execute([
            "book_id" => $bookId,
            "author_id"=> htmlspecialchars($authorId)
         ]);
      }

      $pdo->commit();

      header("location: ../../pages/books/index.php");
      exit();

   $pdo->commit();

   }
   catch (PDOException $e){
      $pdo->rollBack();
      throw $e;
   }
}

?>