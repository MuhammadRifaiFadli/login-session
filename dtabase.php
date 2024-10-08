<?php

function ambil_data() {
    $db = new SQLite3('tambah.db');

    // Membuat tabel jika belum ada
    $db->exec("CREATE TABLE IF NOT EXISTS nama_list (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama TEXT NOT NULL
    )");

    // Ambil semua data dari tabel
    $result = $db->query('SELECT * FROM nama_list');
    $data = [];
    
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $data[] = $row['nama'];
    }

    return $data;
}

function tambah_data($data_baru) {
    $db = new SQLite3('mydb.db');
    $db->exec("INSERT INTO nama_list (nama) VALUES ('" . SQLite3::escapeString($data_baru) . "')");
}

if (isset($_POST['submit'])) {
    $nama_baru = $_POST['nama'];
    tambah_data($nama_baru);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nama</title>
</head>
<body>
    <h2>Input Nama</h2>

    <form method="post" action="">
        <label for="nama">Masukkan Nama:</label>
        <input type="text" name="nama" id="nama" required>
        <input type="submit" name="submit" value="Tambah Nama">
    </form>

</body>
</html>
