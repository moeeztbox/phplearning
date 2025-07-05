<?php
session_start();
session_unset();
session_destroy();
// setcookie("user","",time()-10);
header("Location: Login.php");
exit();
