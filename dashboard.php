<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

function ambil_data() {
    $db = new SQLite3('tambah.db');


    $db->exec("CREATE TABLE IF NOT EXISTS nama_list (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama TEXT NOT NULL
    )");


    $result = $db->query('SELECT * FROM nama_list');
    $data = [];
    
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $data[] = $row['nama'];
    }

    return $data;
}

function tambah_data($data_baru) {
    $db = new SQLite3('tambah.db');


    $stmt = $db->prepare('INSERT INTO nama_list (nama) VALUES (:nama)');
    $stmt->bindValue(':nama', $data_baru, SQLITE3_TEXT);
    $stmt->execute();
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if (isset($_POST['submit'])) {
    $nama_baru = $_POST['nama'];
    tambah_data($nama_baru);
}

$list_nama = ambil_data();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard & Input Nama</title>
</head>
<body>
    <h2>Selamat datang di dashboard</h2>
    <p>Hi, <?php echo htmlspecialchars($_SESSION['username']); ?>, Kamu telah login</p>
    
    <h2>Input Nama</h2>
    <form method="post" action="">
        <label for="nama">Masukkan Nama:</label>
        <input type="text" name="nama" id="nama" required>
        <input type="submit" name="submit" value="Tambah Nama">
    </form>
    <form method="post">
        <button type="submit" name="logout">Logout</button>
    </form>

    <h3>Daftar Nama yang Tersimpan</h3>
    <ul>
        <?php if (!empty($list_nama)) : ?>
            <?php foreach ($list_nama as $nama) : ?>
                <li><?php echo htmlspecialchars($nama); ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</body>
</html>
