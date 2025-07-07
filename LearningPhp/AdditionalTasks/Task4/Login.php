 <?php
session_start();

$validusername="moeez";
$validpassword="1234";

if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST['submit'])){
    $username=$_POST['username'];
    $password=$_POST['password'];
    if($username === $validusername && $password === $validpassword){
        $_SESSION['username']=$username;
        // setcookie("user",$username,time()+10);
        header("Location:Home.php");
        exit();
    }
    else{
        $error="Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="Login.php">
    <label>Username:</label>
    <input type="text" name="username" required>
    <label>Password:</label> 
    <input type="password" name="password" required>
    <button type="submit" name="submit">Login</button>
    <?php if(!empty($error)) echo"<p style='color:red;'>$error</p>" ?>
    </form>
</body>
</html>