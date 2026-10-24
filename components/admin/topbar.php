<?php

session_start();

$user = $_SESSION['user'];

?>

<header class="app-topbar">
  <div class="page-title">
    <h1><?= $pageTitle ?></h1>
    <p><?= $pageSubtitle ?></p>
  </div>
  <div class="topbar-user">
    <span class="avatar">BS</span>
    <div>
      <?= $user['name'] ?? 'Guest' ?><br>
      <span class="badge badge-member" style="margin-top:2px;"><?= $user['role'] == 'member' ? 'Member' : 'Admin' ?></span>
    </div>
  </div>
</header>
