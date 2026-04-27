<?php
include __DIR__ . '/../layout/header.php';

if (!isset($_SESSION['user'])) {
    header("Location: ?page=login");
    exit;
}

$clientModel = new \App\Models\Client();
$clients = $clientModel->getAll(null, 100, 0);
?>

<h2>Clients</h2>

<a class="btn" href="?page=create-client">+ Add Client</a>

<br><br>

<table>
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Company</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($clients as $c): ?>
        <tr>
            <td><?= $c['name'] ?></td>
            <td><?= $c['email'] ?></td>
            <td><?= $c['company'] ?></td>
            <td>
                <a href="?page=edit-client&id=<?= $c['id'] ?>" class="btn btn-primary">
                    Edit
                </a> <br><br>
                <a href="?action=delete-client&id=<?= $c['id'] ?>" class="btn btn-danger">
                    Delete

                </a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../layout/footer.php'; ?>