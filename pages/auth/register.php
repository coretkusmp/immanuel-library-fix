<?php

session_start();

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

?>

<!DOCTYPE html>
<html lang="id">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registrasi - Perpustakaan Digital</title>
   <link rel="stylesheet" href="../../styles/auth/register.css">
</head>

<body>

   <div class="auth-wrapper">
      <div class="auth-card">
         <div class="auth-logo">
            <span class="logo-badge">PD</span>
            Perpustakaan Digital
         </div>
         <h1>Buat Akun Baru</h1>
         <p class="auth-subtitle">Daftar untuk mulai meminjam dan mengelola buku.</p>

         <form method="POST" action="../../actions/auth/register.php">
            <div class="form-group">
               <label for="name">Nama Lengkap</label>
               <input value="<?= $old['name'] ?? '' ?>" type="text" id="name" name="name" placeholder="Contoh: Budi Santoso">
               <?php if (isset($errors['name'])): ?>
                  <p style="font-size: 12px; margin-top: 4px; color: red;">
                     <?= $errors['name'] ?>
                  </p>
               <?php endif ?>
            </div>
            <div class="form-group">
               <label for="email">Email</label>
               <input value="<?= $old['email'] ?? '' ?>" type="email" id="email" name="email" placeholder="nama@sekolah.sch.id">
               <?php if (isset($errors['email'])): ?>
                  <p style="font-size: 12px; margin-top: 4px; color: red;">
                     <?= $errors['email'] ?>
                  </p>
               <?php endif ?>
            </div>
            <div class="form-row">
               <div class="form-group">
                  <label for="password">Kata Sandi</label>
                  <input type="password" id="password" name="password" placeholder="Minimal 8 karakter">
                  <?php if (isset($errors['password'])): ?>
                     <p style="font-size: 12px; margin-top: 4px; color: red;">
                        <?= $errors['password'] ?>
                     </p>
                  <?php endif ?>
               </div>
               <div class="form-group">
                  <label for="password_confirmation">Ulangi Kata Sandi</label>
                  <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi">
                  <?php if (isset($errors['password_confirmation'])): ?>
                     <p style="font-size: 12px; margin-top: 4px; color: red;">
                        <?= $errors['password_confirmation'] ?>
                     </p>
                  <?php endif ?>
               </div>
            </div>

            <button name="register" type="submit" class="btn btn-primary btn-block">Daftar</button>
         </form>

         <p class="form-footer-link">
            Sudah punya akun? <a href="login.php">Masuk di sini</a>
         </p>
      </div>
   </div>
</body>

</html>