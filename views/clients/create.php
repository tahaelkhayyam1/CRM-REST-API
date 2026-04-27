<?php include __DIR__ . '/../layout/header.php';

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}
?>

<h2>Create Client</h2>

<form method="POST" action="?action=create-client">

    <input type="text" name="name" placeholder="Name" required><br><br>

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="text" name="phone" placeholder="Phone"><br><br>

    <input type="text" name="company" placeholder="Company"><br><br>

    <button type="submit">Save</button>
</form>

<?php include __DIR__ . '/../layout/footer.php'; ?>