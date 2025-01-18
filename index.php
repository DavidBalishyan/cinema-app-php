<?php
session_start();
require_once "db.php";
include "./partials/header.php";

$stmt = $pdo->query("SELECT movies.*, users.username FROM movies JOIN users ON movies.user_id = users.id ORDER BY movies.created_at DESC");
$movies = $stmt->fetchAll();
?>
<script src="https://cdn.tailwindcss.com"></script>
<h1 class="text-4xl font-bold mb-6 text-center">Welcome to the Cinema App</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  <?php foreach ($movies as $movie): ?>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <img src="<?php echo htmlspecialchars($movie['photo_path']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="w-full h-64 object-cover">
      <div class="p-4">
        <h2 class="text-2xl font-semibold"><?php echo htmlspecialchars($movie['title']); ?></h2>
        <p class="mt-2 text-gray-600"><?php echo htmlspecialchars($movie['description']); ?></p>
        <p class="mt-2 text-gray-500"><strong>Genre:</strong> <?= htmlspecialchars($movie['genre']); ?></p>
        <p class="mt-2 text-gray-500"><strong>Uploaded by:</strong> <?= htmlspecialchars($movie['username']); ?></p>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $movie['user_id']): ?>
          <div class="mt-4 flex space-x-2">
            <a href="/views/edit.php?id=<?php echo $movie['id']; ?>" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">Edit</a>
            <a href="/views/delete.php?id=<?php echo $movie['id']; ?>" class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">Delete</a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include "./partials/footer.php"; ?>
