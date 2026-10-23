<?php

require_once __DIR__ . "/../config/database.php";

function getCategories()
{
   global $pdo;

   $query = "select * from categories";
   
   $stmt = $pdo->prepare($query);
   $stmt->execute();

  $categories = $stmt->fetchAll();

  return $categories;
}

function getCategory()
{
  $category = [
    "id"          => 1,
    "name"        => "Fiksi",
    "description" => "Novel dan cerita rekaan",
  ];

  return $category;
}

function isCategoryExists($categoryId){
   global $pdo;
   $query = "select count(id) from categories where id = :category_id";
   $stmt = $pdo->prepare($query);
   $stmt -> execute([
      'category_id' => $categoryId
   ]);
   $isCategoryExists = $stmt->fetchColumn();

   return $isCategoryExists;
}
