<!DOCTYPE html>
<html>
<body>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Name: <input type="text" name="fname">
  Test: <div id='test'><img src="test.jpg" alt="test.jpg"></div>
  <input type="submit">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $name = $_POST['fname'];
    if (empty($name)) {
        echo "Name is empty";
    } else {
        echo $name;
    }
    echo "<br/>";
    echo "Test - ";
    echo "<br/>";
    echo $_POST['test'];
}
?>

</body>
</html>
