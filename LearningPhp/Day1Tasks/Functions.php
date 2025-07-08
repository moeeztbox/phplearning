<?php

echo "<h3>User Defined Functions</h3>";

function add() {
    echo "Function without Parameters<br>";
    $num1 = 5;
    $num2 = 5;
    echo "$num1 + $num2 = " . ($num1 + $num2) . ".";
}
add();

function sub($num1, $num2) {
    echo "<br>Function with Parameters<br>";
    echo "$num1 - $num2 = " . ($num1 - $num2) . ".";
}
sub(5, 5);

function mul($num1, $num2) {
    echo "<br>Function with Return Value<br>";
    return $num1 * $num2;
}
$num1 = 5;
$num2 = 5;
$result = mul($num1, $num2);
echo "$num1 * $num2 = $result";

echo "<h3>Predefined Functions</h3>";

$name = "Moeez";

echo "<h3>String Functions</h3>";
echo "Name is $name<br>";
echo "Length of name: " . strlen($name) . "<br>";
echo "Lowercase: " . strtolower($name) . "<br>";
echo "Uppercase: " . strtoupper($name) . "<br>";
echo "Reverse: " . strrev($name) . "<br>";
echo "Replace: " . str_replace("Moeez", "Ali", $name) . "<br>";
echo "Position of 'e': " . strpos($name, "e") . "<br>";

$num1 = 7.6;
$num2 = -15;

echo "<h3>Number Functions</h3>";
echo "Numbers are $num1 and $num2<br>";
echo "Max: " . max(3, 5, 9, 1) . "<br>";
echo "Min: " . min(3, 5, 9, 1) . "<br>";
echo "Round: " . round($num1) . "<br>";
echo "Absolute: " . abs($num2) . "<br>";
echo "Square Root of 16: " . sqrt(16) . "<br>";
echo "Power of 2^3: " . pow(2, 3) . "<br>";
echo "Random number (1-60): " . rand(1, 60) . "<br>";

echo "<h3>Date & Time Functions</h3>";
echo "Current Year: " . date("Y") . "<br>";
echo "Current Date: " . date("d-m-Y") . "<br>";
echo "Current Time: " . date("h:i:s A") . "<br>";

$skills = ["HTML", "CSS", "PHP", "JavaScript"];

echo "<h3>📦 Array Functions</h3>";
echo "Array Entities are:<br>";
print_r($skills);
echo "<br>Total skills: " . count($skills) . "<br>";
echo "Is 'PHP' in array? " . (in_array("PHP", $skills) ? "Yes" : "No") . "<br>";
echo "First skill: " . reset($skills) . "<br>";
echo "Last skill: " . end($skills) . "<br>";
echo "Reversed Array:<br>";
print_r(array_reverse($skills));
echo "<br>Sorted Array:<br>";
sort($skills);
print_r($skills);
echo "<br>Array as String: " . implode(", ", $skills) . "<br><br>";

echo "<h3>🛠️ Miscellaneous</h3>";
$emptyVariable = "";
$nullVariable = null;

echo "Is \$emptyVariable empty? " . (empty($emptyVariable) ? "Yes" : "No") . "<br>";
echo "Is \$nullVariable null? " . (is_null($nullVariable) ? "Yes" : "No") . "<br>";
echo "Type of \$name: " . gettype($name) . "<br>";
echo "Type of \$num1: " . gettype($num1) . "<br>";
echo "Type of \$num2: " . gettype($num2) . "<br>";
echo "Type of \$skills: " . gettype($skills) . "<br>";

?>
