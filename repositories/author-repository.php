<?php

function getAuthors()
{
  $authors = [
    ["id" => 1, "name" => "Andrea Hirata",          "total_books" => 1],
    ["id" => 2, "name" => "Tere Liye",               "total_books" => 1],
    ["id" => 3, "name" => "J.K. Rowling",            "total_books" => 1],
    ["id" => 4, "name" => "Pramoedya Ananta Toer",   "total_books" => 2],
    ["id" => 5, "name" => "Sapardi Djoko Damono",    "total_books" => 1],
  ];

  return $authors;
}

function getAuthor()
{
  $author = [
    "id"   => 1,
    "name" => "Andrea Hirata",
    "bio"  => "Penulis asal Belitung, dikenal lewat novel Laskar Pelangi.",
  ];

  return $author;
}
