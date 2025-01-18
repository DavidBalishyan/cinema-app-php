*<?php
session_start();
require_once "../db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_SESSION['user_id'])) {
  $title = trim($_POST['title']);
  $description = trim($_POST['description']);
  $genre = trim($_POST['genre']);
  $user_id = $_SESSION['user_id'];

  $photo = $_FILES['photo'];
  $photo_path = 'assets/uploads/' . basename($photo['name']);
  move_uploaded_file($photo['tmp_name'], "../" . $photo_path);

  $stmt = $pdo->prepare("INSERT INTO movies (title, description, photo_path, genre, user_id) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$title, $description, $photo_path, $genre, $user_id]);

  header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>Document</title>
</head>
<body>
  <form method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required class="input input-bordered w-full max-w-xs">
    <textarea name="description" placeholder="Description" required class="textarea textarea-bordered"></textarea>
    <input type="file" name="photo" required class="file-input file-input-bordered w-full max-w-xs">
    <input type="text" name="genre" placeholder="Genre" required class="input input-bordered w-full max-w-xs">
    <button type="submit" class="btn btn-primary mt-2">Upload Movie</button>
  </form>
</body>
</html>