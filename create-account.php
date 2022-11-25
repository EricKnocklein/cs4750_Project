<?php
require("connect-db.php");      // include("connect-db.php");
include("db-func.php");

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
    <h1>Welcome to CS4640 Survey</h1>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
      User Name: <input type="text" name="username" class="form-control" required /> <br/>
      Email: <input type="text" name="email" class="form-control" autofocus required /> <br/>
      Password: <input type="password" name="pwd1" class="form-control" required /> <br/>
      Retype Password: <input type="password" name="pwd2" class="form-control" required /> <br/>
      <input type="submit" value="Sign in" class="btn btn-light"  />   
    </form>
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
   $email_array = getEmails();
   $exists = false;
   foreach ($email_array as $e) {
      if ($e["email"] == $email) {
         $exists = true;
         break;
      }
   }
   if ($exists) {
      echo "Email Already in User";
   } else if (isset($_POST['pwd1']) && isset($_POST['pwd2']) && isset($_POST['username'])) {
      if ($_POST['pwd1'] == $_POST['pwd2']) {
         $pwd = trim($_POST['pwd1']);
         $hash_pwd = md5($pwd);
         echo "here   ";
         addUser($_POST['username'], $email, $hash_pwd);
         echo "    here2    ";
         $_SESSION['user'] = getId($email);
         $_SESSION['pwd'] = $hash_pwd;
         // header('Location: home.php');
      }
   }
}

?>

<?php include('footer.html') ?>
</body>
</html>