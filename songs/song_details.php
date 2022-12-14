<?php
require("connect-db.php");   
require("db-func.php");

//put variables we need here 
$songID = 1; // temp
$avgRating = getSongAvgRating($songID);
$songDetail = songDetails($songID);
$list_of_ratings = displayRatings($songID);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Eric Knocklein and Andre Knocklein">
  <meta name="description" content="Homepage of the Song Rating App">      
  <title>DB interfacing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" /> -->
</head>


<body>
<?php include('header.html') ?> 
<div>
    Average Rating: <?php echo $avgRating; ?>
</div>
<div class="container">
<h1>RATING TABLE</h1>
<table class="table">
  <tr>
    <th>Username</th>
    <th>Rhythm</th>        
    <th>Melody</th>
    <th>Atmosphere</th>  
    <th>General Rating</th>  
    <th>Song Name</th>  
    <th>Duration (Sec)</th>  
    <th>Average Rating</th>  
    <th>Artist</th>
  </tr>
  <?php foreach ($list_of_ratings as $rating): ?>
    <tr>
      <td><?php echo $rating['userName']; ?></td>
      <td><?php echo $rating['rhythm']; ?></td>        
      <td><?php echo $rating['melody']; ?></td>
      <td><?php echo $rating['atmosphere']; ?></td>  
      <td><?php echo $rating['generalRating']; ?></td>  
      <td><?php echo $rating['songName']; ?></td>  
      <td><?php echo $rating['duration']; ?></td>  
      <td><?php echo $rating['avgRating']; ?></td>  
      <td><?php echo $rating['artistName']; ?></td>                  
    </tr>
  <?php endforeach; ?>
</table>
</div>

<?php include('footer.html') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>