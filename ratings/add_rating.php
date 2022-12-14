<?php
require("../connect-db.php");   
require("../db-func.php");

$uid = 1; //temp
$search_term = "";
$search_result = searchSongByName($search_term);
$selected_song = null;
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['btnAction'])) {
        if ($_POST['btnAction'] == 'Add') {
            $rid = rand(0,10);
            addRating(
                $rid, 
                $_POST['songid'], 
                $uid, 
                $_POST['rhythm'],
                $_POST['melody'], 
                $_POST['atmosphere'], 
                $_POST['general'], 
                $_POST['description']
            );
        }
    }
    if (!empty($_POST['searchAction'])) {
        $search_term = $_POST['searchAction'];
        $search_result = searchSongByName($search_term);
        if ($search_result==null) echo "BAD";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Eric Knocklein">
  <meta name="description" content="include some description about your page">      
  <title>DB interfacing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<body>
<?php include('../header.html') ?> 

<div class="container">
    <h1>Add a Rating for a Song</h1>
    <form name="AddRatingForm" action="add_rating.php" method="post">
        <div class="row mb-3 mx-3">
            Song ID:
            <input type="number" class="form-control" name="songid" required 
                value="<?php if ($selected_song!=null) echo $selected_song['id'] ?>"
            />            
        </div>
        <div class="row mb-3 mx-3">
            Rhythm:
            <input type="number" class="form-control" name="rhythm" required/>            
        </div>
        <div class="row mb-3 mx-3">
            Melody:
            <input type="number" class="form-control" name="melody" required/>            
        </div>
        <div class="row mb-3 mx-3">
            Atmosphere:
            <input type="number" class="form-control" name="atmosphere" required/>            
        </div>
        <div class="row mb-3 mx-3">
            General:
            <input type="number" class="form-control" name="general" required/>            
        </div>
        <div class="row mb-3 mx-3">
            Description:
            <input type="text" class="form-control" name="description" required/>            
        </div>
        <div>
            <input type="submit" value="Add" name="btnAction" class="btn btn-dark" 
                title="Add a rating" 
            />
        </div>
    </form>
    <form name="SearchSongs" action="add_rating.php" method="post" id="searchForm">
        <div class="row mb-3 mx-3">
            Search Songs:
            <input type="text" class="form-control" name="searchAction" value="<?php echo $search_term ?>"/>            
        </div>
    </form>
    <table class="table">
        <tr>
            <th>Song Name</th>
            <th>Artist</th>        
            <th>Average Rating</th>
        </tr>
        <?php if ($search_result!=null) foreach ($search_result as $song): ?>
            <tr>
                <td><?php echo $song['songName']; ?></td>
                <td><?php echo $song['artistName']; ?></td>        
                <td><?php echo $song['avgRating']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include('../footer.html') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>