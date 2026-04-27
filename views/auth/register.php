<?php include __DIR__ . '/../layout/header.php'; ?>

<h2>Register</h2>

<?php if (!empty($_SESSION['error'])): ?>
    <p style="color:red;">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </p>
<?php endif; ?>

<form method="POST" action="?action=register">

    <input type="text" name="name" placeholder="Name" required><br><br>

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="password" name="password" placeholder="Password" required><br><br>

    <button type="submit">Register</button>
</form>

<?php include __DIR__ . '/../layout/footer.php'; ?>