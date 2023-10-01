<!DOCTYPE html>
<html>

<head>
    <title>Drug Details</title>
    <style>
        img {
            max-width: 200px; 
            max-height: 200px; 
        }
    </style>
</head>

<body>
    <div>
        <?php
        require_once 'Connect.php';
        
        if (isset($_GET['tradename'])) {
            
            $tradename = $_GET['tradename'];

            $sql = "SELECT * FROM drugs WHERE tradename = '$tradename'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                
                $row = $result->fetch_assoc();

                echo "<h1>Drug Details</h1>";
                echo "<h2>Name: " . $row["TradeName"] . "</h2>";
                echo "<img src='" . $row["Images"] . "' alt='Drug Image'>";
                echo "<p>Category: " . $row["Category"] . "</p>";
                echo "<p>Formula: " . $row["Formula"] . "</p>";
                echo "<p>Price: Ksh." . $row["Price"] . "</p>";

                $conn->close();
            } else {
                echo "Drug not found.";
            }
        } else {
            echo "Drug not found.";
        }
        ?>
    </div>
</body>

</html>
