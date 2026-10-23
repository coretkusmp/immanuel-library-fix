<?php

require_once __DIR__ . "/../config/database.php";

function getBooks()
{
   global $pdo;

   $query = "select b.id, b.title, b.stock, c.name as category from books b
            left join categories c on b.category_id = c.id
   ";

   $stmt = $pdo -> prepare($query);

   $stmt -> execute();

   $books = $stmt -> fetchAll();

   $query = "select ba.book_id, a.name from book_author ba
            left join authors a on ba.author_id = a.id
   ";

   $stmt = $pdo -> prepare($query);

   $stmt -> execute();

   $bookAuthors = $stmt -> fetchAll();

   $bookByAuthors = [];
   foreach($bookAuthors as $bookAuthor){
      $bookByAuthors[$bookAuthor['book_id']][] = $bookAuthor['name'];
   }

   foreach($books as $index => $book){
      $books[$index]['authors'] = $bookByAuthors[$book['id']] ?? [];
   }

  return $books;
}

function getBook($id)
{
   global $pdo;

   $query = "select b.id, b.title, b.isbn, b.year, b.stock, b.category_id, b.description, c.name as category 
             from books b 
             left join categories c on b.category_id = c.id 
             where b.id = :id";

   $stmt = $pdo->prepare($query);
   $stmt->execute([
      "id" => $id
   ]);

  $book = $stmt->fetch();

  if(!$book){
   header("Location: ../pages/books/index.php");
   exit;
  }

  $query = "select a.id, a.name from book_author ba
            left join authors a on ba.author_id = a.id
            where ba.book_id = :book_id
           ";
   $stmt = $pdo->prepare($query);
   $stmt->execute([
      "book_id" => $book["id"]
   ]);

   $authorIds = $stmt->fetchAll();

   $book["authors"] = array_column($authorIds, "name");
   $book["author_ids"] = array_column($authorIds, "id");

  return $book;
}

function isIsbnTaken($isbn, $ignoreBookId){
   global $pdo;

   $bookId = intval($ignoreBookId);

   $query = "select count(id) from books where isbn = :isbn && id != :book_id";
   $stmt = $pdo->prepare($query);
   $stmt -> execute([
      'isbn' => $isbn,
      'book_id' => $bookId
   ]);
   $isIsbnTaken = $stmt->fetchColumn();

   return $isIsbnTaken;
}
