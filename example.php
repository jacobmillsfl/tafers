<!DOCTYPE html>
<html>
<body>

<h1>Test PHP Page</h1>

<?php
echo "<p>Hello World!</p>";

// This is a single-line comment

# This is also a single-line comment

/*
This is a multiple-lines comment block
that spans over multiple
lines
*/

// You can also use comments to leave out parts of a code line
$x = 5 /* + 15 */ + 5; //global variable scope
echo $x;

function myTest() {
    // using x inside this function will generate an error
    echo "<p>Variable x inside function is: $x</p>";
}
myTest();

echo "<p>Variable x outside function is: $x</p>";

$y = 10;

function myTest2() {
    global $x, $y; //global keyword used to access global variable inside function
    $y = $x + $y;
}

myTest2();
echo $y; // outputs 15
?>

</body>
</html>
