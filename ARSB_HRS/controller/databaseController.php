<?php
//Database
function connectDB(){
    return new mysqli("localhost", "root", '', 'arsb_hrs');
}
//Users
function getUser($conn)
{
    $sql = $conn->prepare("SELECT * FROM staff");
    $sql->execute();
    $result = $sql->get_result();
    $sql->close();
    return $result;
}
function getSpecificUser($conn,$id){
    $sql = $conn->prepare("SELECT * FROM staff WHERE id=?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    $sql->close();
    return $result;
}
function viewUser()
{
    $conn = connectDB();
    $result = getUser($conn);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td> <input type=\"radio\" name=\"user\" value=\"" . $row["id"] . "\"/></td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["age"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . date("d-m-Y", strtotime($row["date of birth"])) ."</td>";
            echo "<td>" . $row["address"] ."</td>";
            echo "<td>" . $row["maritial status"] . "</td>";
            switch ($row["position"]) {
                case 1:
                    echo "<td>Director</td>";
                    break;
                case 2:
                    echo "<td>Manager</td>";
                    break;
                case 3:
                    echo "<td>Human Resource Executive</td>";
                    break;
                case 4:
                    echo "<td>Accountant Executive</td>";
                    break;
                case 5:
                    echo "<td>Project Manager</td>";
                    break;
                case 6:
                    echo "<td>Assistant Project Manager</td>";
                    break;
                case 7:
                    echo "<td>Administrator</td>";
                    break;
                case 8:
                    echo "<td>IT Manager</td>";
                    break;
                case 9:
                    echo "<td>IT Engineer</td>";
                    break;
                case 10:
                    echo "<td>IT Technical</td>";
                    break;
                case 11:
                    echo "<td>Procurement Manager</td>";
                    break;
                default:
                    echo "<td>Undefined</td>";
                    break;
            }
            echo "<td>" . $row["annual leaves"] . "</td>";
            echo "<td>" . $row["medical leaves"] . "</td>";
            echo "<td>" . $row["emergency leaves"] . "</td>";
            echo "</tr>";
        }
    } else
        echo "<tr><td></td><td>No Users</td></tr>";
    $conn->close();
}
function deleteUser($id){
    $conn = connectDB();
    $sql = $conn->prepare("DELETE FROM staff WHERE id=?");
    $sql->bind_param("i", $id);
    $sql->execute();
    if ($sql->affected_rows>0)
        echo "<script>alert('Record deleted successfully');</script>;";
    else
        echo "<script>alert('Error deleting record: " . $sql->error. "');</script>";
    $sql->close();
    $conn->close();
}
function editUser($id, $name, $age, $email, $dob, $address, $ms, $position, $al, $mc, $el){
    $conn = connectDB();
    $sql = $conn->prepare("UPDATE staff SET email=?, name=?, age=?, `date of birth`=?, address=?, `maritial status`=?, position=?, `annual leaves`=?,  `medical leaves`=?,
                    `emergency leaves`=? WHERE id=?");
    $sql->bind_param("ssisssiiiii", $email ,$name, $age, $dob, $address, $ms, $position, $al, $mc, $el, $id);
    $sql->execute();
    if ($sql->affected_rows>0)
        echo '<script>alert("Record updated successfully");</script>';
    else
        echo '<script>alert("Error updating record: ' . $sql->error. '");</script>';
    $sql->close();
    $conn->close();
}
function addUser($name, $age, $email, $dob, $address, $ms, $position, $al, $mc, $el){
    $conn = connectDB();
    $sql = $conn->prepare("INSERT INTO staff (`email`, `name`, `age`, `date of birth`, `address`, `maritial status`, `position`, `annual leaves`, `medical leaves`, `emergency leaves`)
                            VALUES (?,?,?,?,?,?,?,?,?,?)");
    $sql->bind_param("ssisssiiii", $email, $name, $age, $dob, $address, $ms, $position, $al, $mc, $el);
    $sql->execute();
    if($sql->affected_rows>0)
        echo '<script>alert("User added successfully");</script>';
    else
        echo '<script>alert("Error adding record: ' . $sql->error . '");</script>';
    $sql->close();
    $conn->close();
}
function passwordReset($id,$password){
    $conn = connectDB();
    $sql = $conn->prepare("UPDATE staff SET password =? WHERE id=?");
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql->bind_param("si", $password , $id);
    $sql->execute();
    if ($sql->affected_rows>0)
        echo '<script>alert("Password changed successfully");</script>';
    else
        echo '<script>alert("Error updating record: ' . $sql->error. '");</script>';
    $sql->close();
    $conn->close();
}
function createPasswordDB($email,$password){
    $conn = connectDB();
    $sql = $conn->prepare("UPDATE staff SET password=? WHERE email=?");
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql->bind_param("ss", $password, $email);
    $sql->execute();
    if ($sql->affected_rows > 0)
        echo '<script>alert("Password has been created successfully"); </script>';
    else
        echo '<script>alert("Error creating password: ' . $sql->error . '");</script>';
    $sql->close();
    $conn->close();
}
//Leaves
function getLeaves($conn, $userID)
{
    $sql = $conn->prepare("SELECT leaves.id, staff.name, leaves.reason, leaves.date_from, leaves.date_to, leaves.type_of_leave, leaves.approval
                            FROM leaves
                            INNER JOIN staff
                            ON staff.id=leaves.staff_id
                            WHERE staff_id=?");
    $sql->bind_param("i", $userID);
    $sql->execute();
    $result = $sql->get_result();
    $sql->close();
    return $result;
}
function getSpecificLeave($conn, $leave)
{
    $sql = $conn->prepare("SELECT leaves.id, staff.name, leaves.reason, leaves.date_from, leaves.date_to, leaves.type_of_leave
                            FROM leaves
                            INNER JOIN staff
                            ON staff.id=leaves.staff_id
                            WHERE leaves.id=?");
    $sql->bind_param("i", $leave);
    $sql->execute();
    $result = $sql->get_result();
    $sql->close();
    return $result;
}
function fetchLeaves($userID){
    $conn = connectDB();
    $result = getLeaves($conn,$userID);
    if ($result->num_rows>0) {
        while ($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "<td> <input type=\"radio\" name=\"leave\" value=\"" . $row["id"] . "\"/></td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['reason'] . "</td>";
            echo "<td>" . date("d-m-Y", strtotime($row['date_from'])) . "</td>";
            echo "<td>" . date("d-m-Y", strtotime($row['date_to'])) . "</td>";
            switch ($row['type_of_leave']){
                case 1;
                    echo "<td>Annual Leave</td>";
                    break;
                case 2;
                    echo "<td>Medical Leave</td>";
                    break;
                default;
                    echo "<td>Emergency Leave</td>";
            }
            switch ($row['approval']) {
                case 1;
                    echo "<td>Under Review</td>";
                    break;
                case 2;
                    echo "<td>Reviewed</td>";
                    break;
                case 3;
                    echo "<td>Waiting Approval</td>";
                    break;
                case 4;
                    echo "<td>Approved</td>";
                    break;
                default;
                    echo "<td>Not Approved</td>";
            }
            echo "</tr>";
        }
    }
    else
        echo "<tr><td></td><td>No Leaves</td></tr>";
    $conn->close();
}
function addleave($userID, $reason, $date_from, $date_to, $type) {
    $conn = connectDB();
    $sql = $conn->prepare("INSERT INTO leaves (staff_id , date_from, date_to, reason, type_of_leave, approval)
                            VALUES (?,?,?,?,?,?)");
    $approval = 1;
    $sql->bind_param("isssii", $userID, $date_from, $date_to, $reason, $type, $approval);
    $sql->execute();
    if ($sql->affected_rows > 0)
        echo '<script>alert("Record has been added successfully");</script>';
    else
        echo '<script>alert("Error adding record: ' . $sql->error . '");</script>';
    $sql->close();
    $conn->close();
}
function editLeave($leave, $reason, $date_from, $date_to, $type_of_leave){
    $conn = connectDB();
    $sql = $conn->prepare("UPDATE leaves SET reason=?, date_from=?, date_to=?, type_of_leave=?
                    WHERE id=?");
    $sql->bind_param("sssii", $reason, $date_from, $date_to, $type_of_leave, $leave);
    $sql->execute();
    if ($sql->affected_rows > 0)
        echo '<script>alert("Record updated successfully");</script>';
    else
        echo '<script>alert("Error updating record: ' . $sql->error . '");</script>';
    $sql->close();
    $conn->close();
}
function deleteLeave($leave)
{
    $conn = connectDB();
    $sql = $conn->prepare("DELETE FROM leaves WHERE id=?");
    $sql->bind_param("i", $leave);
    $sql->execute();
    if ($sql->affected_rows > 0)
        echo "<script>alert('Record deleted successfully');</script>;";
    else
        echo "<script>alert('Error deleting record: " . $sql->error . "');</script>";
    $sql->close();
    $conn->close();
}
function listLeavesManager($userID)
{
    $conn = connectDB();
    $sql = $conn->prepare("SELECT * FROM staff WHERE managed_by=?");
    $sql->bind_param("i", $userID);
    $sql->execute();
    $ID = $sql->get_result();
    $sql->close();
    if($ID->num_rows>0){
        while($managedID = $ID->fetch_assoc()){
            $result = getLeaves($conn, $managedID['id']);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['approval'] == 1) {
                        echo "<tr>";
                        echo "<td> <input type=\"radio\" name=\"leave\" value=\"" . $row["id"] . "\"/></td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['reason'] . "</td>";
                        echo "<td>" . date("d-m-Y", strtotime($row['date_from'])) . "</td>";
                        echo "<td>" . date("d-m-Y", strtotime($row['date_to'])) . "</td>";
                        switch ($row['type_of_leave']) {
                            case 1;
                                echo "<td>Annual Leave</td>";
                                break;
                            case 2;
                                echo "<td>Medical Leave</td>";
                                break;
                            default;
                                echo "<td>Emergency Leave</td>";
                        }
                        switch ($row['approval']) {
                            case 1;
                                echo "<td>Under Review</td>";
                                break;
                            default;
                                break;
                        }
                        echo "</tr>";
                    }
                }
            }
        }
    }else{
        echo "<tr><td></td><td>No Approvals Pending</td></tr>";
    }
    $conn->close();
}
function listLeavesHigher($approval)
{
    $conn = connectDB();
    $sql = $conn->prepare("SELECT * FROM leaves WHERE approval=?");
    $sql->bind_param("i", $approval);
    $sql->execute();
    $ID = $sql->get_result();
    $sql->close();
    if ($ID->num_rows > 0) {
        while ($approved = $ID->fetch_assoc()) {
            $result = getLeaves($conn, $approved['staff_id']);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row['approval'] == 2) {
                        echo "<tr>";
                        echo "<td> <input type=\"radio\" name=\"leave\" value=\"" . $row["id"] . "\"/></td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['reason'] . "</td>";
                        echo "<td>" . date("d-m-Y", strtotime($row['date_from'])) . "</td>";
                        echo "<td>" . date("d-m-Y", strtotime($row['date_to'])) . "</td>";
                        switch ($row['type_of_leave']) {
                            case 1;
                                echo "<td>Annual Leave</td>";
                                break;
                            case 2;
                                echo "<td>Medical Leave</td>";
                                break;
                            default;
                                echo "<td>Emergency Leave</td>";
                        }
                        switch ($row['approval']) {
                            case 2;
                                echo "<td>Reviewed</td>";
                                break;
                            default;
                                break;
                        }
                        echo "</tr>";
                    } else
                    if ($row['approval'] == 3) {
                        echo "<tr>";
                        echo "<td> <input type=\"radio\" name=\"leave\" value=\"" . $row["id"] . "\"/></td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['reason'] . "</td>";
                        echo "<td>" . date("d-m-Y", strtotime($row['date_from'])) . "</td>";
                        echo "<td>" . date("d-m-Y", strtotime($row['date_to'])) . "</td>";
                        switch ($row['type_of_leave']) {
                            case 1;
                                echo "<td>Annual Leave</td>";
                                break;
                            case 2;
                                echo "<td>Medical Leave</td>";
                                break;
                            default;
                                echo "<td>Emergency Leave</td>";
                        }
                        switch ($row['approval']) {
                            case 3;
                                echo "<td>Awaiting Approval</td>";
                                break;
                            default;
                                break;
                        }
                        echo "</tr>";
                    }
                }
            }
        }
    } else {
        echo "<tr><td></td><td>No Approvals Pending</td></tr>";
    }
    $conn->close();
}
function approveManager($leave){
    $conn = connectDB();
    $sql = $conn->prepare("UPDATE leaves SET approval=? WHERE id=?");
    $approval = 2;
    $sql->bind_param("ii", $approval ,$leave);
    $sql->execute();
    if ($sql->affected_rows > 0)
        echo '<script>alert("Approved successfully");</script>';
    else
        echo '<script>alert("Error updating record: ' . $sql->error . '");</script>';
    $sql->close();
    $conn->close();
}
function approveHR($leave){
    $conn = connectDB();
    $sql = $conn->prepare("UPDATE leaves SET approval=? WHERE id=?");
    $approval = 3;
    $sql->bind_param("ii", $approval, $leave);
    $sql->execute();
    if ($sql->affected_rows > 0)
        echo '<script>alert("Approved successfully");</script>';
    else
        echo '<script>alert("Error updating record: ' . $sql->error . '");</script>';
    $sql->close();
    $conn->close();
}
function approveDirector($leave){
    $conn = connectDB();
    $sql = $conn->prepare("UPDATE leaves SET approval=? WHERE id=?");
    $approval = 4;
    $sql->bind_param("ii", $approval, $leave);
    $sql->execute();
    if ($sql->affected_rows > 0)
        echo '<script>alert("Approved successfully");</script>';
    else
        echo '<script>alert("Error updating record: ' . $sql->error . '");</script>';
    $sql->close();
    $conn->close();
}
function disapprove($leave){
    $conn = connectDB();
    $sql = $conn->prepare("UPDATE leaves SET approval=? WHERE id=?");
    $approval = 0;
    $sql->bind_param("ii", $approval, $leave);
    $sql->execute();
    if ($sql->affected_rows > 0)
        echo '<script>alert("Disapproved successfully");</script>';
    else
        echo '<script>alert("Error updating record: ' . $sql->error . '");</script>';
    $sql->close();
    $conn->close();
}
//Claims
function getClaims($conn, $userID){
    $sql = $conn->prepare("SELECT claims.id, staff.name, claims.date, claims.destination_from, claims.destination_to, claims.reason, claims.km, claims.vehicle, claims.fee, claims.petrol, claims.tol, claims.parking, claims.fee, claims.entertainment, claims.other
                            FROM claims
                            INNER JOIN staff
                            ON staff.id=claims.staff_id
                            WHERE staff_id=?");
   $sql->bind_param("i", $userID);
    $sql->execute();
    $result = $sql->get_result();
    $sql->close();
    return $result;
}
function getSpecificClaims($conn, $claim){
    $sql = $conn->prepare("SELECT claims.id, staff.name, claims.date, claims.destination_from, claims.destination_to, claims.reason, claims.km, claims.vehicle, claims.fee, claims.petrol, claims.tol, claims.parking, claims.meal, claims.entertainment, claims.other
                            FROM claims
                            INNER JOIN staff
                            ON staff.id=claims.staff_id
                            WHERE claims.id=?");
    $sql->bind_param("i", $claim);
    $sql->execute();
    $result = $sql->get_result();
    $sql->close();
    return $result;
}
function listClaims($userID){
    $conn = connectDB();
    $result = getClaims($conn, $userID);
    if($result -> num_rows > 0){
        while ($row = $result->fetch_assoc()){
            echo "<tr>";
            echo "<td> <input type=\"radio\" name=\"claim\" value=\"" . $row["id"] . "\"/> </td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . date("d-m-Y", strtotime($row['date'])) . "</td>";
            echo "<td>" . $row['destination_from'] . "</td>";
            echo "<td>" . $row['destination_to'] . "</td>";
            echo "<td>" . $row['reason'] . "</td>";
            echo "<td>" . $row['km'] . "</td>";
            switch ($row['vehicle']) {
                case 1:
                    echo "<td> Car (Company) </td>";
                    break;
                case 2:
                    echo "<td> Car (Personal) </td>";
                    break;
                case 3:
                    echo "<td> Motorcycle </td>";
                    break;
                default:
                    echo "<td> Undefined </td>";
            }
            echo "<td>" . $row['fee'] . "</td>";
            echo "<td>" . $row['petrol'] . "</td>";
            echo "<td>" . $row['tol'] . "</td>";
            echo "<td>" . $row['parking'] . "</td>";
            echo "<td>" . $row['meal'] . "</td>";
            echo "<td>" . $row['entertainment'] . "</td>";
            echo "<td>" . $row['other'] . "</td>";
            $total = $row['fee'] + $row['petrol'] + $row['tol'] + $row['parking'] + $row['meal'] + $row['entertainment'] + $row['other'];
            switch($row['vehicle']){
                case 2:
                    $calc = 0.20;
                    break;
                case 3:
                    $calc = 0.10;
                    break;
                default:
                    $calc = 0;
                    break;
            }
            $total += ($row['km'] * $calc);
            echo "<td>" . round($total, 2) . "</td>";
        }
    }
}
function addClaims($userID){
    $conn = connectDB();
    
}
?>