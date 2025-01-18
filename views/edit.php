<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: /index.php");
    exit;
}

$movie_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Fetch movie data to edit
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $movie_id, 'user_id' => $user_id]);
$movie = $stmt->fetch();

if (!$movie) {
    echo "You are not authorized to edit this movie.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $genre = trim($_POST['genre']);

    if ($title && $description && $genre) {
        $updateStmt = $pdo->prepare("UPDATE movies SET title = :title, description = :description, genre = :genre WHERE id = :id AND user_id = :user_id");
        $updateStmt->execute([
            'title' => $title,
            'description' => $description,
            'genre' => $genre,
            'id' => $movie_id,
            'user_id' => $user_id
        ]);

        header("Location: /index.php");
        exit;
    } else {
        $error = "All fields are required.";
    }
}

include "../partials/header.php";
?>

<h1 class="text-3xl font-bold mb-6">Edit Movie</h1>

<?php if (isset($error)): ?>
  <p class="text-red-500 mb-4"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST" class="space-y-4">
  <div>
    <label for="title" class="block text-sm font-medium text-gray-700">Movie Title</label>
    <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($movie['title']); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
  </div>
  <div>
    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
    <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required><?php echo htmlspecialchars($movie['description']); ?></textarea>
  </div>
  <div>
    <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
    <input type="text" name="genre" id="genre" value="<?php echo htmlspecialchars($movie['genre']); ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
  </div>
  <div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
    <a href="/index.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
  </div>
</form>

<?php include "../partials/footer.php"; ?>
