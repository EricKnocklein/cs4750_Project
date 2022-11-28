<?php
require("connect-db.php");   
require("db-func.php");

//put variables we need here 
session_start();
$uid = $_SESSION['user'];
$list_of_ratings = getUsersRatings($uid); 
$top_songs = getTopSongs();
?>

<?php
// Here we set out variables like in the example of POTD 5

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//   if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Add') {
//       addFriend($_POST['name'], $_POST['major'], $_POST['year']);
//       $list_of_friends = getAllFriends();  
//   } else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Update') {
//       $friend_to_update = getFriendByName($_POST['friend_to_update']);
//   } else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Delete') {
//     deleteFriend($_POST['friend_to_delete']);
//     $list_of_friends = getAllFriends(); 
//   } else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Confirm Update') {
//     updateFriend($_POST['name'], $_POST['major'], $_POST['year']);
//     $list_of_friends = getAllFriends();
//   }
// }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Eric Knocklein and Andre Knocklein">
  <meta name="description" content="Homepage of the Song Rating App">      
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" /> -->
</head>


<body>
<?php include('header.php') ?> 
<div class="container">
<?php if (isset($_SESSION['user'])): ?>
  <h1>My Ratings</h1>
  <table class="table">
    <tr>
      <th>Artist</th>
      <th>Song Name</th>
      <th>Rhythm</th>        
      <th>Melody</th>
      <th>Atmosphere</th>  
      <th>General Rating</th>  
      <th>Average Rating</th>  
      <th></th>
    </tr>
    <?php foreach ($list_of_ratings as $rating): ?>
      <tr>
        <td><?php echo $rating['artistName']; ?></td>
        <td><?php echo $rating['songName']; ?></td>
        <td><?php echo $rating['rhythm']; ?></td>        
        <td><?php echo $rating['melody']; ?></td>
        <td><?php echo $rating['atmosphere']; ?></td>  
        <td><?php echo $rating['generalRating']; ?></td>  
        <td><?php echo $rating['avgRating']; ?></td>  
        <td>
          <form action="rating_details.php" method="post">
            <input type="submit" value="Details" name="btnAction" class="btn btn-primary" 
                  title="Click to See Rating Details" />
            <input type="hidden" name="selected_rating" 
                  value="<?php echo $rating['id']; ?>"
            />                
          </form>
        </td>              
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

<h1>Popular Songs</h1>
<table class="table">
  <tr>
    <th>Song Name</th>
    <th>Average Rating</th>        
    <th>Duration (Sec)</th>
    <th>Artist</th>
    <?php if (isset($_SESSION['user'])): ?>
      <th></th>
    <?php endif; ?>
  </tr>
  <?php foreach ($top_songs as $song): ?>
    <tr>
      <td><?php echo $song['songName']; ?></td>
      <td><?php echo $song['avgRating']; ?></td>        
      <td><?php echo $song['duration']; ?></td>
      <td><?php echo $song['artist']; ?></td>
      <?php if (isset($_SESSION['user'])): ?>
        <td>
          <form action="song_details.php" method="post">
            <input type="submit" value="Details" name="btnAction" class="btn btn-primary" 
                  title="Click to See Song Details" />
            <input type="hidden" name="selected_song" 
                  value="<?php echo $song['id']; ?>"
            />                
          </form>
        </td>
      <?php endif; ?>               
    </tr>
  <?php endforeach; ?>
</table>
</div>

<?php include('footer.html') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>