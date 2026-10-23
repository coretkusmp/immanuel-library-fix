<?php
require_once __DIR__ . "/../../repositories/category-repository.php";
require_once __DIR__ . "/../../repositories/author-repository.php";

session_start();
$categories = getCategories();
$authors = getAuthors();

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

$pageTitle = "Tambah Buku";
$pageSubtitle = "Lengkapi data buku, kategori, dan penulis";
?>

<!DOCTYPE html>
<html lang="id">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tambah Buku - Perpustakaan Digital</title>
   <link rel="stylesheet" href="../../styles/books/create.css">
</head>

<body>
   <div class="app-shell">
      <?php require_once __DIR__ . "/../../components/admin/sidebar.php" ?>

      <main class="app-main">
         <?php require_once __DIR__ . "/../../components/admin/topbar.php" ?>

         <div class="app-content">
            <form method="POST" action="../../actions/books/store.php">
               <div class="form-card" style="margin-bottom:20px;">
                  <div class="form-section-title">Data Buku</div>
                  <div class="form-group">
                     <label for="title">Judul Buku</label>
                     <input value="<?= $old['title'] ?? '' ?>" type="text" id="title" name="title" placeholder="Contoh: Laskar Pelangi">
                     <?php if (isset($errors['title'])): ?>
                        <p style="font-size: 12px; margin-top: 4px; color: red;">
                           <?= $errors['title'] ?>
                        </p>
                     <?php endif ?>
                  </div>
                  <div class="form-row">
                     <div class="form-group">
                        <label for="isbn">ISBN</label>
                        <input value="<?= $old['isbn'] ?? '' ?>" type="text" id="isbn" name="isbn" placeholder="Contoh: 978-979-1227-78-0">
                        <?php if (isset($errors['isbn'])): ?>
                           <p style="font-size: 12px; margin-top: 4px; color: red;">
                              <?= $errors['isbn'] ?>
                           </p>
                        <?php endif ?>
                     </div>
                     <div class="form-group">
                        <label for="year">Tahun Terbit</label>
                        <input value="<?= $old['year'] ?? '' ?>" type="number" id="year" name="year" placeholder="Contoh: 2005">
                        <?php if (isset($errors['year'])): ?>
                           <p style="font-size: 12px; margin-top: 4px; color: red;">
                              <?= $errors['year'] ?>
                           </p>
                        <?php endif ?>
                     </div>
                  </div>
                  <div class="form-row">
                     <div class="form-group">
                        <label for="stock">Jumlah Stok</label>
                        <input value="<?= $old['stock'] ?? '' ?>" type="number" id="stock" name="stock" placeholder="Contoh: 10">
                        <?php if (isset($errors['stock'])): ?>
                           <p style="font-size: 12px; margin-top: 4px; color: red;">
                              <?= $errors['stock'] ?>
                           </p>
                        <?php endif ?>
                     </div>
                     <div class="form-group">
                        <label for="category_id">Kategori</label>
                        <select id="category_id" name="category_id">
                           <?php foreach ($categories as $category): ?>
                              <option <?= $old['category_id'] ?? '' == $category['id'] ? 'selected' : '' ?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                           <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['category_id'])): ?>
                           <p style="font-size: 12px; margin-top: 4px; color: red;">
                              <?= $errors['category_id'] ?>
                           </p>
                        <?php endif ?>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="description">Deskripsi</label>
                     <textarea id="description" name="description" rows="3" placeholder="Sinopsis singkat buku"><?= $old['description'] ?? '' ?></textarea>
                     <?php if (isset($errors['description'])): ?>
                        <p style="font-size: 12px; margin-top: 4px; color: red;">
                           <?= $errors['description'] ?>
                        </p>
                     <?php endif ?>
                  </div>
               </div>

               <div class="form-card">
                  <div class="form-section-title">Penulis Buku</div>
                  <div class="form-group">
                     <label>Pilih Penulis (bisa lebih dari satu)</label>
                     <div class="checkbox-grid">
                        <?php foreach ($authors as $author): ?>
                           <label class="checkbox-item">
                              <input <?= in_array($author['id'], $old['author_ids'] ?? []) ? 'checked' : '' ?> type="checkbox" name="author_ids[]" value="<?= $author['id'] ?>">
                              <?= $author['name'] ?>
                           </label>
                        <?php endforeach; ?>
                     </div>
                     <?php if (isset($errors['author_ids'])): ?>
                        <p style="font-size: 12px; margin-top: 4px; color: red;">
                           <?= $errors['author_ids'] ?>
                        </p>
                     <?php endif ?>
                  </div>

                  <div class="form-actions">
                     <a href="index.php" class="btn btn-outline">Batal</a>
                     <button type="submit" name="store" class="btn btn-primary">Simpan Buku</button>
                  </div>
               </div>
            </form>
         </div>
      </main>
   </div>
</body>

</html>