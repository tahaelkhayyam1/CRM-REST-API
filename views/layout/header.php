<!DOCTYPE html>
<html>
<head>
    <title>ClientFlow</title>
    <style>
        body { font-family: Arial; margin: 0; background: #f4f4f4; }
        .container { width: 80%; margin: auto; padding: 20px; }
        nav { background: #333; padding: 10px; color: white; }
        nav a { color: white; margin-right: 10px; text-decoration: none; }
        table { width: 100%; background: white; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; }
        .btn { padding: 6px 10px; background: #007bff; color: white; text-decoration: none; }
        .btn-danger { background: red; }
    </style>
</head>
<body>

<nav>
    <a href="?page=clients">Clients</a>
    <a href="?page=create-client">Create Client</a>
    <a href="?action=logout">Logout</a>
</nav>

<div class="container">