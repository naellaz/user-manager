<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Manager</title>
<style>
  body { font-family: Arial; margin: 50px; background: #f7f8fa; }
  form { background: #fff; padding: 20px; border-radius: 10px; width: 300px; }
  input, button { margin: 5px 0; padding: 8px; width: 100%; }
  img { width: 60px; border-radius: 50%; }
</style>
</head>
<body>
<h2>Tambah Pengguna</h2>

<form method="POST" enctype="multipart/form-data">
  <input type="text" name="name" placeholder="Nama" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="file" name="photo" accept="image/*" required>
  <button type="submit" name="submit">Simpan</button>
</form>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Upload foto
    $target_dir = $_ENV['STORAGE_PATH'];
    $filename = time() . "_" . basename($_FILES["photo"]["name"]);
    $target_file = $target_dir . $filename;

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, photo) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $filename]);
        echo "<p>✅ Data berhasil disimpan!</p>";
    } else {
        echo "<p>❌ Gagal upload foto.</p>";
    }
}
?>

<h2>📋 Daftar Pengguna</h2>
<table border="1" cellpadding="8" cellspacing="0">
<tr><th>ID</th><th>Nama</th><th>Email</th><th>Foto</th></tr>

<?php
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['name']}</td>
            <td>{$row['email']}</td>
            <td><img src='upload/{$row['photo']}'></td>
          </tr>";
}
?>
</table>
</body>
</html>
