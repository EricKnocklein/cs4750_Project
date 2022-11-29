<?php
require("connect-db.php");   
require("db-func.php");

//put variables we need here 
$albumID = null;
$avgRating = getAlbumAvgRating($albumID);
$albumDetail = albumDetails($albumID);
$artists = getArtistsByAlbum($albumID);
$songs = getSongsByAlbum($albumID);
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!empty($_POST['btnAction'])) {
            if ($_POST['btnAction'] == 'View Album') {
                $albumID = intval($_POST["selected_album"]);
                $avgRating = getAlbumAvgRating($albumID);
                $albumDetail = albumDetails($albumID);
                $artists = getArtistsByAlbum($albumID);
                $songs = getSongsByAlbum($albumID);
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
  <meta name="description" content="Page Where you Inspect Albums">      
  <title>Album Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" /> -->
</head>


<body>
<?php include('header.php'); ?> 
<div class="container">

<h1><b><?php echo $albumDetail["albumName"];?></b></h1>
<h2>Details</h2>
<div class="container">
  <b>Average Song Rating: </b><?php echo $avgRating;?><br/>
</div>
<h2>Songs</h2>
<div class="container">
  <table class="table">
    <tr>
      <th>Song</th>
      <th>Duration</th>
      <th>Average Rating</th>
      <th></th>
    </tr>
    <?php foreach ($songs as $song): ?>
      <tr>
        <td><?php echo $song['songName']; ?></td>
        <td><?php echo $song['duration']; ?></td>
        <td><?php echo $song['avgRating']; ?></td>     
        <td>
            <form action="song_details.php" method="post">
            <input type="submit" value="Details" name="btnAction" class="btn btn-primary" 
                    title="Click to See Song Details" />
            <input type="hidden" name="selected_song" 
                    value="<?php echo $song['id']; ?>"
            />                
            </form>
        </td>                 
      </tr>
    <?php endforeach; ?>
  </table>
  </div>
<h2>Artists</h2>
<div class="container">
  <table class="table">
    <tr>
      <th>Artist</th>
      <th>Average Rating for Artist</th>
    </tr>
    <?php foreach ($artists as $artist): ?>
      <tr>
        <td><?php echo $artist['artistName']; ?></td>
        <td><?php echo getArtistAvgRating($artist['id']); ?></td>                       
      </tr>
    <?php endforeach; ?>
  </table>
</div>

</div>

<?php include('footer.html'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>