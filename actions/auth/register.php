<?php

session_start();

require_once __DIR__ . "/../../validations/auth-validation.php";
require_once __DIR__ . "/../../config/database.php";

if (isset($_POST['register']) && $_SERVER['REQUEST_METHOD'] === 'POST') {

   try {
      $pdo->beginTransaction();
      $request = getRegisterRequest($_POST);
      $errors = validateRegister($request);

      if (count($errors) > 0) {
         $_SESSION['errors'] = $errors;

         unset($request['password'], $request['password_confirmation']);

         $_SESSION['old'] = $request;

         header('Location: ../../pages/auth/register.php');
         exit;
      }

      $query = "insert into users (name, email, password, role) values 
               (:name, :email, :password, :role)";
      
      $stmt = $pdo->prepare($query);
      $stmt->execute([
         'name' => $request['name'],
         'email' => $request['email'],
         'password' => password_hash($request['password'], PASSWORD_BCRYPT),
         'role' => 'member',
      ]);

      $pdo->commit();

      $_SESSION['success'] = "Registrasi pengguna baru sudah berhasil";

      header('Location: ../../pages/auth/login.php');
      exit;


   } catch (PDOException $e) {
      $pdo->rollBack();
      throw $e;
   }
}
