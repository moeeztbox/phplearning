<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Calculator</title>
</head>
<body>

<form method="post">
    <label>First Number:</label>
    <input type="number" name="num1" required>

    <label>Second Number:</label>
    <input type="number" name="num2" required>

    <label>Operations:</label>
    <select name="operation">
        <option value="selectoption">Select an Option</option>
        <option value="add">Addition</option>
        <option value="subtract">Subtraction</option>
    </select>

    <button type="submit" name="calculate">Calculate</button>
</form>

<?php
if (isset($_POST['calculate'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operation = $_POST['operation'];

    if ($operation == "selectoption") {
        echo "<div>Please Select an Option</div>";
    } elseif ($operation == "add") {
        $result = $num1 + $num2;
        echo "<div>$num1 + $num2 = $result</div>";
    } elseif ($operation == "subtract") {
        $result = $num1 - $num2;
        echo "<div>$num1 - $num2 = $result</div>";
    }
}
?>

</body>
</html>
