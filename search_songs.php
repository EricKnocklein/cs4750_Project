<?php
require("connect-db.php");   
require("db-func.php");

session_start();
$uid = $_SESSION['user'];
$search_term = "";
$search_result = searchSongByName($search_term);
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
  <title>Search</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<body>
<?php include('header.php') ?> 
<div class="container">
</form>
    <form name="SearchSongs" action="search_songs.php" method="post" id="searchForm">
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