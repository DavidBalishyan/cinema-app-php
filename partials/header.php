<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cinema App</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <header class="bg-gray-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center py-4">
      <a href="index.php" class="text-xl font-bold">Cinema App</a>
      <nav>
        <ul class="flex space-x-4">
          <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="./views/upload.php" class="hover:text-gray-300">Upload Movie</a></li>
            <li><a href="./views/logout.php" class="hover:text-gray-300">Logout</a></li>
          <?php else: ?>
            <li><a href="./views/login.php" class="hover:text-gray-300">Login</a></li>
            <li><a href="./views/register.php" class="hover:text-gray-300">Register</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>
  <main class="container mx-auto p-6">
