<?php
require("connect-db.php");   
require("db-func.php");

//put variables we need here 
$ratingID = null;
$ratingDetails = ratingDetails($ratingID);
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['btnAction'])) {
        if ($_POST['btnAction'] == 'Details' || $_POST['btnAction'] == "Edit") {
            $ratingID = intval($_POST["selected_rating"]);
            $ratingDetails = ratingDetails($ratingID);
        } else if ($_POST['btnAction'] == 'Update') {
            $id = $_POST['ratingid'];
            $rhythm = $_POST['rhythm'];
            $melody = $_POST['melody'];
            $atmosphere = $_POST['atmosphere'];
            $general = $_POST['general'];
            $desc = $_POST['description'];
            editRating($id, $rhythm, $melody, $atmosphere, $general, $desc);
            $ratingID = intval($_POST["ratingid"]);
            $ratingDetails = ratingDetails($ratingID);
        } else if ($_POST['btnAction'] == 'Delete') {
            deleteRating($_POST['ratingid']);
            header('Location: home.php');
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
  <meta name="description" content="Page where you inspect ratings">      
  <title>Rating Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <!-- <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" /> -->
</head>


<body>
<?php include('header.php') ?> 
<div class="container">
    <?php $song = songDetails( $ratingDetails["songID"]) ?>
    <?php if (isset($_SESSION['user']) && $_SESSION['user'] == $ratingDetails["id"]): ?>
        <h1>Edit a Rating for <b><?php echo $song["songName"];?></b></h1>
        <form name="EditDeleteRatingForm" action="rating_details.php" method="post">
            <div class="row mb-3 mx-3">
                <input type="hidden" class="form-control" name="songid" required 
                    value="<?php if ($song["id"]!=null) echo $song["id"] ?>"
                    min=0 max=10
                />
                <input type="hidden" class="form-control" name="ratingid" required 
                    value="<?php echo $ratingID ?>"
                    min=0 max=10
                />           
            </div>
            <div class="row mb-3 mx-3">
                Rhythm:
                <input type="number" class="form-control" name="rhythm" required 
                    value="<?php echo $ratingDetails["rhythm"] ?>"
                    min=0 max=10
                />            
            </div>
            <div class="row mb-3 mx-3">
                Melody:
                <input type="number" class="form-control" name="melody" required
                    value="<?php echo $ratingDetails["melody"] ?>"
                    min=0 max=10
                />            
            </div>
            <div class="row mb-3 mx-3">
                Atmosphere:
                <input type="number" class="form-control" name="atmosphere" required
                    value="<?php echo $ratingDetails["atmosphere"] ?>"
                    min=0 max=10
                />            
            </div>
            <div class="row mb-3 mx-3">
                General:
                <input type="number" class="form-control" name="general" required
                    value="<?php echo $ratingDetails["generalRating"] ?>"
                    min=0 max=10
                />            
            </div>
            <div class="row mb-3 mx-3">
                Description:
                <input type="text" class="form-control" name="description"
                    value="<?php echo $ratingDetails["description"] ?>"
                />            
            </div>
            <div>
                <input type="submit" value="Update" name="btnAction" class="btn btn-dark" 
                    title="Update a rating" 
                />
                <input type="submit" value="Delete" name="btnAction" class="btn btn-danger" 
                    title="Delete a rating" 
                />
            </div>
        </form>
        <br/>
    <?php endif; ?>
    <?php if (!isset($_SESSION['user']) || $_SESSION['user'] != $ratingDetails["id"]): ?>
        <h1>Rating by <b><?php echo $ratingDetails["userName"]?></b></h1>
        <h2>Song Information</h2>
        <div class="container">
            <b>Song: </b><?php echo $song["songName"]?><br/>
            <b>Album: </b><?php echo $song["albumName"]?><br/>
        </div>
        <h2>Rating</h2>
        <div class="container">
            <b>General Rating: </b><?php echo $ratingDetails["generalRating"]?><br/>
            <b>Atmosphere: </b><?php echo $ratingDetails["atmosphere"]?><br/>
            <b>Melody: </b><?php echo $ratingDetails["melody"]?><br/>
            <b>Rhythm: </b><?php echo $ratingDetails["rhythm"]?><br/>
            <b>Description:</b></br>
            <p><?php echo $ratingDetails["description"]?></p></br>
        </div>
    <?php endif; ?>

</div>

<?php include('footer.html') ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>