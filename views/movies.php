<?php
$stmt = $pdo->query("SELECT movies.*, users.username FROM movies JOIN users ON movies.user_id = users.id");
$movies = $stmt->fetchAll();
foreach ($movies as $movie) {
  ?>
    <div class="card w-96 bg-base-100 shadow-xl">
      <figure><img src="<?php echo $movie['photo_path']; ?>" alt="Movie Photo"></figure>
      <div class="card-body">
        <h2 class="card-title"><?php echo $movie['title']; ?></h2>
        <p><?php echo $movie['description']; ?></p>
        <p><strong>Genre:</strong> <?php echo $movie['genre']; ?></p>
        <p><strong>Uploaded by:</strong> <?php echo $movie['username']; ?></p>
      </div>
    </div>
  <?php
}
?>