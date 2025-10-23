<?php
require 'init.php';

// Dodawanie użytkownika
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'add') {
    $stmt = $pdoUsers->prepare(
        "INSERT INTO users (imie, nazwisko, wiek, telefon, adres) VALUES (?, ?, ?, ?, ?)"
    );
    $stmt->execute([
        $_POST['imie'],
        $_POST['nazwisko'],
        $_POST['wiek'],
        $_POST['telefon'],
        $_POST['adres']
    ]);
    header("Location: users.php");
    exit;
}

// Usuwanie użytkownika
if (isset($_GET['delete'])) {
    $stmt = $pdoUsers->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: users.php");
    exit;
}

// Pobieranie wszystkich użytkowników
$users = $pdoUsers->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Użytkownicy</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>

<h2>Dodaj użytkownika</h2>
<form method="POST">
    <input type="hidden" name="action" value="add">
    <input type="text" name="imie" placeholder="Imię" required>
    <input type="text" name="nazwisko" placeholder="Nazwisko" required>
    <input type="number" name="wiek" placeholder="Wiek">
    <input type="text" name="telefon" placeholder="Numer telefonu">
    <input type="text" name="adres" placeholder="Adres">
    <button type="submit">Dodaj</button>
</form>

<h2>Lista użytkowników</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Wiek</th>
        <th>Telefon</th>
        <th>Adres</th>
        <th>Akcja</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= htmlspecialchars($user['id']) ?></td>
        <td><?= htmlspecialchars($user['imie']) ?></td>
        <td><?= htmlspecialchars($user['nazwisko']) ?></td>
        <td><?= htmlspecialchars($user['wiek']) ?></td>
        <td><?= htmlspecialchars($user['telefon']) ?></td>
        <td><?= htmlspecialchars($user['adres']) ?></td>
        <td><a href="?delete=<?= $user['id'] ?>" onclick="return confirm('Czy na pewno usunąć?')">Usuń</a></td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
