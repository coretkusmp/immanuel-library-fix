<?php

function getUsers()
{
  $users = [
    ["id" => 1, "name" => "Admin Utama",    "email" => "admin@ski.sch.id",               "role" => "admin"],
    ["id" => 2, "name" => "Budi Santoso",   "email" => "budi.santoso@siswa.ski.sch.id",  "role" => "member"],
    ["id" => 3, "name" => "Siti Aminah",    "email" => "siti.aminah@siswa.ski.sch.id",   "role" => "member"],
    ["id" => 4, "name" => "Richard Marcell","email" => "richard.m@ski.sch.id",           "role" => "admin"],
  ];

  return $users;
}

function getUser()
{
  $user = [
    "id"    => 2,
    "name"  => "Budi Santoso",
    "email" => "budi.santoso@siswa.ski.sch.id",
    "role"  => "member",
  ];

  return $user;
}

function getProfile()
{
  $profile = [
    "user_id" => 2,
    "phone"   => "0812-3456-7890",
    "address" => "Jl. Merdeka No. 21, Pontianak, Kalimantan Barat",
    "bio"     => "Murid kelas XI TKJ yang gemar membaca novel fiksi dan buku pengembangan diri.",
  ];

  return $profile;
}
