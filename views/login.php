<?php
session_start();
require_once "../db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: /index.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}

include "../partials/header.php";
?>

<div class="min-h-screen flex items-center justify-center">
  <div class="max-w-md w-full bg-white p-8 rounded shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Login to Your Account</h2>
    <?php if (isset($error)): ?>
      <p class="text-red-500 text-sm mb-4"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" class="space-y-4">
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" name="username" id="username" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <input type="password" name="password" id="password" required class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500">
      </div>
      <div>
            <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</button>
          </div>
      <p class="text-center text-sm text-gray-500">Don't have an account? <a href="/views/register.php" class="text-blue-500 hover:underline">Register here</a>.</p>
    </form>
  </div>
</div>

<?php include "../partials/footer.php"; ?>
