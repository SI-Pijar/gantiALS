<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Operator</title>
    <link rel="stylesheet" href="/gantiALS/ALS/public/css/operator.css?v=4">
</head>
<body>
    <div class="login-card">
        <h2>Login Operator</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form action="/gantiALS/ALS/index.php?controller=operator&action=login" method="POST">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="Masukkan email operator">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Masukkan password">
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>