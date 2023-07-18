<!DOCTYPE html>
<html>
<head>
	<title>Pharmacy Dispense</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<div class="content">
	<h1>Pharmacy Dispense</h1>

	<?php
	require_once("connect.php");

	// Get pharmacy ID from query string
	$id = $_GET['id'];

	// Get data from the 'pharmacy' table for the specified ID
	$sql = "SELECT * FROM pharmacy WHERE id='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo "<h2>" . $row['name'] . "</h2>";

	// Get data from the 'dispensing' table for the specified pharmacy
	$sql = "SELECT * FROM dispensing WHERE pharmacyID='$id'";
	$result = $conn->query($sql);

	// Display the dispensing table
	echo "<table>";
	echo "<tr><th>Trade Name</th><th>Quantity</th><th>Price</th><th>Edit</th><th>Delete</th></tr>";
	while ($row = $result->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $row['tradename'] . "</td>";
		echo "<td>" . $row['quantity'] . "</td>";
		echo "<td>" . $row['price'] . "</td>";
		echo "<td><a href='pharmacyEdit.php?id=" . $row['id'] . "'>Edit</a></td>";
		echo "<td><form method='post'><input type='hidden' name='id' value='" . $row['id'] . "'><input type='submit' name='delete' value='Delete'>Delete</form></td>";
		echo "</tr>";
	}
	echo "</table>";

	// Handle delete request
	if (isset($_POST['delete'])) {
		$id = $_POST['id'];

		// Get the tradename and quantity of the selected dispensing record
		$sql = "SELECT tradename, quantity FROM dispensing WHERE id='$id'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$tradename = $row['tradename'];
		$quantity = $row['quantity'];

		// Delete the selected dispensing record
		$sql = "DELETE FROM dispensing WHERE id='$id'";
		if ($conn->query($sql) === TRUE) {
			// Increment the stock table with the quantity of the deleted record
			$sql = "UPDATE stock SET quantity=quantity+'$quantity' WHERE tradename='$tradename'";
			$conn->query($sql);

			// Redirect back to the dispensing table
			header("Location: pharmacyDispense.php?id=" . $_GET['id']);
			exit();
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	?>

	<a href="pharmacy.php">Back to Pharmacy List</a>
	<br>
	<a href="pharmacyAdd.php?id=<?php echo $_GET['id']; ?>">Add New Dispensing Record</a>

</body>
</html>