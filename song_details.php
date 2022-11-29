<?php
require("connect-db.php");   
require("db-func.php");

//put variables we need here 
$songID = null;
$avgRating = getSongAvgRating($songID);
$songDetail = songDetails($songID);
$list_of_ratings = displayRatings($songID);
$artistsInfo = getArtistsBySong($songID);
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!empty($_POST['btnAction'])) {
    if ($_POST['btnAction'] == 'Details') {
      $songID = intval($_POST["selected_song"]);
      $avgRating = getSongAvgRating($songID);
      $songDetail = songDetails($songID);
      $list_of_ratings = displayRatings($songID);
      $artistsInfo = getArtistsBySong($songID);
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Eric Knocklein and Andre Knocklein">
  <meta name="description" content="Page where you inspect songs">      
  <title>Song Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" /> -->
</head>


<body>
<?php include('header.php') ?> 
<div class="container">
<h1><b><?php echo $songDetail["songName"]?></b></h1>
<h2>Details</h2>
<div class="container">
  <b>Duration in Seconds: </b><?php echo $songDetail["duration"];?><br/>
  <b>Average Song Rating: </b><?php echo $songDetail["avgRating"];?><br/>
  <b>Album: </b><?php echo $songDetail["albumName"];?><br/>
  <b>Average Rating for Songs on the Album: </b><?php echo getAlbumAvgRating($songDetail["albumID"]);?><br/><br/>
  <form action="album_details.php" method="post">
    <input type="submit" value="View Album" name="btnAction" class="btn btn-primary" 
        title="View Album" />
    <input type="hidden" name="selected_album" 
        value="<?php echo $songDetail["albumID"]; ?>"
    />                
  </form>
  </div>
  <br/><h2>Artists</h2>
  <div class="container">
  <table class="table">
    <tr>
      <th>Artist</th>
      <th>Average Rating for Artist</th>
    </tr>
    <?php foreach ($artistsInfo as $artist): ?>
      <tr>
        <td><?php echo $artist['artistName']; ?></td>
        <td><?php echo $artist['avgSongRating']; ?></td>                       
      </tr>
    <?php endforeach; ?>
  </table>
</div>
<br/><h2>Ratings</h2>
<div class="container">
<br/>
<?php if (isset($_SESSION['user'])): ?>
  <form action="add_rating.php" method="post">
    <input type="submit" value="Add Rating" name="btnAction" class="btn btn-primary" 
        title="Select a Song to Rate" />
    <input type="hidden" name="selected_song" 
        value="<?php echo $songID; ?>"
    />                
  </form>
  <br/>
<?php endif; ?>
<table class="table">
  <tr>
    <th>Username</th>
    <th>Rhythm</th>        
    <th>Melody</th>
    <th>Atmosphere</th>  
    <th>General Rating</th> 
    <th></th> 
  </tr>
  <?php foreach ($list_of_ratings as $rating): ?>
    <tr>
      <td><?php echo $rating['userName']; ?></td>
      <td><?php echo $rating['rhythm']; ?></td>        
      <td><?php echo $rating['melody']; ?></td>
      <td><?php echo $rating['atmosphere']; ?></td>  
      <td><?php echo $rating['generalRating']; ?></td>
      <?php 
        if (isset($_SESSION['user']) && $_SESSION['user'] == $rating["id"]) {
          $text = "Edit";
        } else {
          $text = "Details";
        }
      ?>
      <td>
        <form action="rating_details.php" method="post">
          <input type="submit" value="<?php echo $text;?>" name="btnAction" class="btn btn-primary" 
                title="Click to See Rating Details" />
          <input type="hidden" name="selected_rating" 
                value="<?php echo $rating['rid']; ?>"
          />                
        </form>   
      </td>
    </tr>
  <?php endforeach; ?>
</table>
</div>

<?php include('footer.html') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>