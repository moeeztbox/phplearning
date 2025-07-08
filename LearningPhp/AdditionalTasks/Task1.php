<?php

function splitCSV($input) {
    $array = explode(',', $input);
    return $array;
}

function splitArray($input) {
    $text = implode('--', $input);
    return $text;
}

$text = "Apple,Banana,Orange,Grapes,Mango,Strawbery,Plump";
echo "Text To Array:<br>";
print_r(splitCSV($text));

$skills = ["Cricket", "Football", "Badminton", "Swimming", "Tennis"];
echo "<br>Array to Text:<br>" . splitArray($skills);

?>
