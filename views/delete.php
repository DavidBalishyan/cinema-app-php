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

// Check if the movie belongs to the current user
$stmt = $pdo->prepare("SELECT * FROM movies WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $movie_id, 'user_id' => $user_id]);
$movie = $stmt->fetch();

if (!$movie) {
    echo "You are not authorized to delete this movie.";
    exit;
}

// Delete the movie if confirmed
$stmt = $pdo->prepare("DELETE FROM movies WHERE id = :id AND user_id = :user_id");
$stmt->execute(['id' => $movie_id, 'user_id' => $user_id]);

header("Location: /index.php");
exit;