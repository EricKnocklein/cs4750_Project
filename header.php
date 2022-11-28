<?php session_start(); ?>
<header>
  <nav class="navbar navbar-expand-md navbar-dark bg-light">
    <?php 
      if (isset($_SESSION['user'])) {
        echo "<div class='nav-item'>You are logged in as " . getUserData($_SESSION['user'])[0]["userName"] . "</div>";
        echo "<a class='nav-item nav-link' href='logout.php'>Logout</a>";
      } else {
        echo "<a class='nav-item nav-link' href='login.php'>Login</a>";
      }
    ?>
    <a class='nav-item nav-link' href="home.php">Homepage</a>
    <a class='nav-item nav-link' href="add_rating.php">Search and Add Rating</a>
    <!-- Can add more links as we add functionality -->
  </nav>
</header>
