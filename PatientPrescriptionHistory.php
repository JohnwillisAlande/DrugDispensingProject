<?php
    require_once "Connect.php";
?>
<!DOCTYPE html>
<html>

<body>
    <div>
        <ul>
            <li><a href='./Patient.html'>Dashboard</a></li>
            <li><a href='./PatientPrescriptionHistory.php'>Drug</a></li>
        </ul>
    </div>

    <h2>ALL PATIENT PRESCRIPTION HISTORY</h2>
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
</body>

</html>