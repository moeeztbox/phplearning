<?php

$name           = "Moeez";
$age            = 18;
$universityName = "Garrison";
$cgpa           = 2.5;
$isStudent      = true;
$hobbies        = ["Football", "Swimming"];

echo "My name is $name.<br>";
echo "My age is $age.<br>";
echo "I study in $universityName University.<br>";
echo "My CGPA is $cgpa.<br>";
echo ($isStudent ? "I am a Student" : "I am not a Student") . ".<br>";
echo "My hobbies are playing $hobbies[0] and $hobbies[1].";

?>
