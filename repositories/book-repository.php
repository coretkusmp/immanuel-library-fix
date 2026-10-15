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

function getBook()
{

  $book = [
    "id" => 5,
    "title" => "Antologi Rasa Nusantara",
    "isbn" => "978-602-1234-56-7",
    "year" => 2021,
    "stock" => 4,
    "category_id" => 1,
    "category" => "Fiksi",
    "description" => "Kumpulan puisi dan cerita pendek dari berbagai penulis Nusantara.",
    "author_ids" => [4, 5],
    "authors" => ["Pramoedya Ananta Toer", "Sapardi Djoko Damono"],
  ];
  return $book;
}