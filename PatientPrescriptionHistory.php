<?php
    require_once "Connect.php";
?>
<!DOCTYPE html>
<html>

<body>
<div class="background-container" style="position: absolute; top: -10; right: 5; padding: 10px;">
        <div class="navbar">
            <img src="images/afyahealth.png" class="logo">
            <ul>
                <li><a href="pharmacy.html">Dashboard</a></li>
                <li><a href="PatientPrescriptionHistory.php">Prescriptions</a></li>
            </ul>
        </div>

    <h1>PATIENT PRESCRIPTION HISTORY</h1>
    <div>
        <?php
        if(isset($_COOKIE['userType'])&& $_COOKIE['userType']=="Patient"){
            $name=$_COOKIE['name'];
            echo "<div> Patient Name :". $name . "</div>";
            $sql="SELECT * FROM Patients WHERE PatientName='$name' limit 1";
            $result=mysqli_query($conn,$sql);
            
            if(mysqli_num_rows($result)===1){
                $row=mysqli_fetch_assoc($result);
                $PatientID=$row['PatientID'];
                $sql2="SELECT * FROM PRESCRIPTION WHERE PatientID='$PatientID'";
                $resultOfPresc=mysqli_query($conn,$sql2);
                if(mysqli_num_rows($resultOfPresc)>0){
                    echo "<div>";
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>Trade Name</th>";
                    echo "<th>Dosage</th>";
                    echo "<th>DoctorID</th>";
                    echo "<th>Date Precribed</th>";
                    echo "</tr>";
                while($row2=mysqli_fetch_assoc($resultOfPresc)){
                echo "<tr>";
                echo "<td>" . $row2["tradeName"] . "</td>";
                echo "<td>" . $row2["quantity"] . "</td>";
                echo "<td>" . $row2["doctorID"] . "</td>";
                echo "<td>" . $row2["datePrescribed"] . "</td>";
                echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";

                }else{
                 echo "<div> User not set or Patient not Signed in </div>";
                }
            }
        }else{
           echo "<div> User not set or Patient not signed in </div>";
        }
        
        ?>
    </div>
    </div>
</body>

</html>