<?php

const LOGIN_URL = "/pages/auth/login.php";
const BOOK_INDEX_URL = "/pages/books/index.php";
const FORBIDDEN_URL = "/pages/errors/403.php";

function sessionStart()
{
   if (session_status() === PHP_SESSION_NONE) {
      session_start();
   }
}

function isLoggedIn()
{
   sessionStart();
   $isLoggedIn = isset($_SESSION['user']);

   return $isLoggedIn;
}

function getAuthUser()
{
   sessionStart();
   $user = $_SESSION['user'] ?? null;

   return $user;
}

function hasRole(array $roles)
{
   $user = getAuthUser();
   $isUserHasAuthorizeRole = $user !== null && in_array($user['role'], $roles);

   return $isUserHasAuthorizeRole;
}

function requireAuth() {
   if(!isLoggedIn()){
      $_SESSION['errors'] = [
         'login' => 'silahkan login terlebih dahulu sebelum mengakses halaman ini'
      ];

      header('Location: ' . LOGIN_URL);
      exit;
   }
}

function requireRole(array $roles){
   requireAuth();

   if(!hasRole($roles)){
      header('Location: ' . FORBIDDEN_URL);
      exit;
   }
}

function requireGuest(){
   if(isLoggedIn()){
      header('Location: ' . BOOK_INDEX_URL);
      exit;
   }
}
