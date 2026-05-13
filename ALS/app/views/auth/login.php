<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Admin - PT. Antar Lintas Sumatera</title>
  <link rel="stylesheet" href="public/css/admin.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="HalamanLogin">
  <div class="KotakLogin">
    <div class="KepalaKotakLogin">
      <img src="public/gambar/logo als.jpg" alt="Logo ALS" width="50" height="50" />
      <div>
        <h3>Admin Panel</h3>
        <p>PT. Antar Lintas Sumatera</p>
      </div>
    </div>

    <?php if (!empty($error)): ?>
      <div class="AlertError">
        <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form action="index.php?page=login&action=proses" method="POST">
      <div class="GrupInput">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required />
      </div>
      <div class="GrupInput">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
      </div>
      <button type="submit" class="TombolLogin">
        <i class="fa-solid fa-right-to-bracket"></i> Masuk
      </button>
    </form>
  </div>
</body>
</html>
