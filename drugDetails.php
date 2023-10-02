<!DOCTYPE html>
<html>

<head>
    <title>Drug Details</title>
    <style>
    * {
        margin: 0;
        padding: 0;
    }

    .section.page:after {
        content: "";
        display: block;
        visibility: hidden;
        height: 0;
        clear: both;
    }

    .section.page {
        padding: 34px 0;
        background-image: linear-gradient(rgba(0, 0, 0, 0.75), rgba(83, 193, 195, 0.75)), url(images/hospitalimage11.jpg);
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        z-index: -1;
    }

    .section.page h1 {
        font-size: 30px;
        text-align: center;
        line-height: 1.6;
        font-weight: 600;
        margin-bottom: 1px;
        margin-top: 20px;
        color: #49e2d3;
    }

    .section.page .media-details h1 {
        text-align: center;
    }

    .section.page p {
        width: 475px;
        margin-left: auto;
        margin-right: auto;
    }

    .section.page .media-details h1 .price {
        color: #9d9f4e;
        padding-right: 10px;
        font-size: 34px;
    }

    .wrapper {
        width: 980px;
        margin: 0 auto;
    }

    .media-details {
        width: 460px;
        margin: 0 auto; /* Add this line to center the element */
        float: center;
    }

    .media-details form {
        margin-left: 0;
        margin-bottom: 10px;
        margin-top: 20px
    }

    .media-details h1 {
    font-size: 30px;
    text-align: center;
    line-height: 1.6;
    font-weight: 600;
    margin-bottom: 10px;
    margin-top: 20px;
    color: #49e2d3;
    text-transform: uppercase;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.media-details table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
    border: 1px solid #ddd;
}

.media-details th {
    font-weight: bold;
    padding: 10px;
    text-align: left;
    background-color: #49e2d3;
    color: #fff;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.media-details td {
    padding: 10px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}

.media-details tr:nth-child(even) {
    background-color: #f2f2f2;
}

.media-details tr:hover {
    background-color: #ddd;
}

.media-details th,
.media-details td {
    border: 1px solid #ddd;
}

.media-details th:first-child,
.media-details td:first-child {
    border-left: none;
}

.media-details th:last-child,
.media-details td:last-child {
    border-right: none;
}

.media-details th,
.media-details td:first-child {
    border-top: none;
}

.media-details th,
.media-details td:last-child {
    border-bottom: none;
}

    img {
        max-width: 250px;
  max-height: 250px;
  margin-bottom: 10px;
  margin-top: 20px;
  display: block;
  margin-left: auto;
  margin-right: auto;
  border-radius: 10px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.5), 0 0 40px rgba(83, 193, 195, 0.7), 0 0 60px rgba(83, 193, 195, 0.9), 0 0 80px rgba(83, 193, 195, 1); /* Adjust the box-shadow values */
  transition: transform 0.3s ease-in-out;
  position: relative;
}

img:before,
img:after {
  content: "";
  position: absolute;
  top: -2px;
  left: -2px;
  right: -2px;
  bottom: -2px;
  border-radius: 10px;
  box-shadow: 0 0 40px #53c1c3, 0 0 80px #53c1c3, 0 0 120px #53c1c3, 0 0 160px #53c1c3; /* Adjust the box-shadow values */
  z-index: -1;
  opacity: 0.5;
  transition: opacity 3s ease-in-out;
}

img:hover:before,
img:hover:after {
  opacity: 1;
}

img:hover {
  transform: scale(1.1);
}
</style>
</head>
<?php
require_once 'Connect.php';

if (isset($_GET['tradename'])) {

    $tradename = $_GET['tradename'];

    $sql = "SELECT * FROM drugs WHERE tradename = '$tradename'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $conn->close();
    } else {
        echo "Drug not found.";
    }
} else {
    echo "Drug not found.";
}
?>                  
<body>
    <div class="section page">
    <div class="wrapper">
        <div class="media-picture">
            <span>
            <img src="<?php echo $row["Images"]; ?>" alt="Drug Image" />
            </span>
        </div>
        
        <div class="media-details">
            <h1><?php echo $row["TradeName"]; ?></h1>
            <table>
                <tr>
                    <th>Name</th>
                    <td><?php echo $row["TradeName"]; ?></td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td><?php echo $row["Category"]; ?></td>
                </tr>
                <tr>
                    <th>Formula</th>
                    <td><?php echo $row["Formula"]; ?></td>
                </tr>
                <tr>
                    <th>Price Ksh.</th>
                    <td><?php echo $row["Price"]; ?></td>
                </tr>
            </table>
                    
        </div>
    </div>
</body>
</html>