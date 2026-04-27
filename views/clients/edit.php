<?php
include __DIR__ . '/../layout/header.php';

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Client ID missing";
    exit;
}

$clientModel = new \App\Models\Client();
$clients = $clientModel->getAll(null, 100, 0);

$currentClient = null;

foreach ($clients as $c) {
    if ($c['id'] == $id) {
        $currentClient = $c;
        break;
    }
}

if (!$currentClient) {
    echo "Client not found";
    exit;
}
?>

<h2>Edit Client</h2>

<form method="POST" action="?action=update-client&id=<?= $id ?>">

    <input
        type="text"
        name="name"
        value="<?= $currentClient['name'] ?>"
        required><br><br>

    <input
        type="email"
        name="email"
        value="<?= $currentClient['email'] ?>"
        required><br><br>

    <input
        type="text"
        name="phone"
        value="<?= $currentClient['phone'] ?>"><br><br>

    <input
        type="text"
        name="company"
        value="<?= $currentClient['company'] ?>"><br><br>

    <button type="submit">
        Update Client
    </button>

</form>

<?php include __DIR__ . '/../layout/footer.php'; ?>