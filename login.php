<?php
require("connect-db.php");      // include("connect-db.php");
require("db-func.php");

//put variables we need here    
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  
  <title>PHP State Maintenance (Session)</title>  
</head>
<body>
   <?php include('header.php') ?> 
  
  <div class="container">
    <h1>Welcome to Tune Rater</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      Email: <input type="text" name="email" class="form-control" autofocus required /> <br/>
      Password: <input type="password" name="pwd" class="form-control" required /> <br/>
      <input type="submit" value="Sign in" class="btn btn-light"  />   
    </form>
    <h3>Don't Have an Account?</h3>
    <a href='create-account.php'>Create Account</a>
  </div>


<?php session_start();    // make sessions available
// Session data are accessible from an implicit $_SESSION global array variable
// after a call is made to the session_start() function.
?>

<?php
// Define a function to handle failed validation attempts 
function reject($entry) {
//    echo 'Please <a href="login.php">Log in </a>';
   exit();    // exit the current script, no value is returned
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && strlen($_POST['email']) > 0){
   $email = trim($_POST['email']);
   $setPwd = getPassword($email)["pwd"];
   if (isset($_POST['pwd'])) {
      $pwd = trim($_POST['pwd']);
      $hash_pwd = md5(md5($pwd));
      echo $setPwd;
      echo $hash_pwd;
      if (strcmp($setPwd, $hash_pwd) == 0) {
         $_SESSION['user'] = getId($email);
         $_SESSION['pwd'] = $hash_pwd;
         header('Location: home.php');
      }
   }
}

?>

<?php include('footer.html') ?>
</body>
</html>
