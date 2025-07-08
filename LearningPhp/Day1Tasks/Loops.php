<?php

echo "<h3>While Loop</h3>";

$num = 0;
while ($num <= 5) {
    echo "Count: $num<br>";
    $num++;
}

echo "<h3>Do-While Loop</h3>";

$num2 = 0;
do {
    echo "Count: $num2<br>";
    $num2++;
} while ($num2 <= 5);

echo "<h3>For Loop</h3>";

for ($i = 0; $i <= 5; $i++) {
    echo "Count: $i<br>";
}

echo "<h3>Foreach Loop</h3>";

$hobbies = ["Cricket", "Football", "Swimming", "Boxing", "Badminton"];
foreach ($hobbies as $hobby) {
    echo "I love $hobby<br>";
}

?>
