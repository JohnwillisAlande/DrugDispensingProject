<?php
require_once("connect.php");

$companyID = "";
$tradename = "";
$formula = "";
$price = "";
$category = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize user inputs
    $tradename = $_POST["tradename"] ?? "";
    $formula = $_POST["formula"] ?? "";
    $price = $_POST["price"] ?? "";
    $category = $_POST["category"] ?? "";

    
    if (empty($tradename) || empty($formula) || empty($price) || empty($category)) {
        echo "Error: Please fill in all the fields.";
    } else {
        
        if (isset($_COOKIE["email"])) {
            $email = $_COOKIE["email"];

            
            $sql = "SELECT companyID FROM pharmaceuticalcompany WHERE email='$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $companyID = $row["companyID"];

                
                if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
                    $imageFile = $_FILES["image"]["tmp_name"];
                    $targetDirectory = "images/"; 
                    $targetFileName = $targetDirectory . basename($_FILES["image"]["name"]);

                    
                    if (move_uploaded_file($imageFile, $targetFileName)) {
                        
                        $sql = "INSERT INTO drugs (companyID, tradename, formula, price, category, Images) VALUES ('$companyID', '$tradename', '$formula', '$price', '$category', '$targetFileName')";

                        if ($conn->query($sql) === TRUE) {
                            echo "Data stored successfully.";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    } else {
                        echo "Error: File upload failed.";
                    }
                } else {
                    echo "Error: File upload failed.";
                }
            } else {
                echo "Error: Company ID not found in database.";
            }
        } else {
            echo "Error: Company ID not found in cookies.";
        }
    }
}


$sql1 = "SELECT * FROM drugs WHERE companyID = '$companyID'";
$result = mysqli_query($conn, $sql1);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pharmaceutical Company Drugs</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    img {
        max-width: 200px;
        max-height: 200px;
    }
    </style>
</head>

<body>
    <div class="background-container" style="position: absolute; top: -10; right: 5; padding: 10px;">
        <div class="navbar">
            <img src="images/afyahealth.png" class="logo">
            <ul>
                <li><a href="pharmaceuticalCompany.html">Dashboard</a></li>
                <li class="active"><a href="companydrugs.php">Drugs</a></li>
                <li><a href="CompanyContracts.php">Contracts</a></li>
            </ul>
        </div>
        <h1>Pharmaceutical Company Drugs</h1>

        <form id="myForm" method="post" action="companydrugs.php" class="form-container" enctype="multipart/form-data">

            <label for="tradename">Trade Name:</label>
            <input type="text" name="tradename" required><br>

            <label for="formula">Formula:</label>
            <input type="text" name="formula" required><br>

            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" required><br>

            <label for="category">Category:</label>
            <input type="text" name="category" required><br>

            <label for="image">Choose a photo:</label>
            <input type="file" name="image" required><br>

            <input type="submit" value="Submit">
        </form>

        <br>
        <h1>Drug Data Table</h1>
        <table>
            <tr>
                <th>Company ID</th>
                <th>Trade Name</th>
                <th>Formula</th>
                <th>Price</th>
                <th>Category</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["CompanyID"] . "</td>";
                    echo "<td>" . $row["TradeName"] . "</td>";
                    echo "<td>" . $row["Formula"] . "</td>";
                    echo "<td>" . $row["Price"] . "</td>";
                    echo "<td>" . $row["Category"] . "</td>";
                    echo "<td><img src='" . $row["Images"] . "'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No data found</td></tr>";
            }
            ?>
        </table>

        <script>
        // Check if the form should be cleared based on local storage
        if (localStorage.getItem("clearFormOnRefresh") === "true") {
            clearForm();
            // Remove the flag from local storage to avoid clearing on subsequent refreshes
            localStorage.removeItem("clearFormOnRefresh");
        }

        // Function to clear the form
        function clearForm() {
            document.getElementById("myForm").reset();
        }

        // Attach an event listener to the form submit button
        document.getElementById("myFormSubmitButton").addEventListener("click", function() {
            // Set a flag in local storage to clear the form on the next refresh
            localStorage.setItem("clearFormOnRefresh", "true");
        });
        </script>

</body>

</html>