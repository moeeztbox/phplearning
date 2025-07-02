 <?php

$name="Moeez";
$age=18;
$universityName="Garrison";
$cgpa=2.5;
$isStudent=true;
$hobbies=["Football","Swimming"];


echo "My name is $name.<br>My age is $age.<br>I study in $universityName University.<br>My CGPA is $cgpa.<br>" .
($isStudent ? "I am a Student": "I am not a Student") . ".<br> My hobbies are playing $hobbies[0] and $hobbies[1].";?> 