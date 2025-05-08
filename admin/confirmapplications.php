<?php
$data = json_decode(file_get_contents('php://input'), true);

// Check if data is set and not null
if (isset($data['id']) && isset($data['logo']) && isset($data['ownername']) && isset($data['owneridentity']) && isset($data['storename']) && isset($data['email']) && isset($data['phonenumber']) && isset($data['country']) && isset($data['license'])) {
    // Retrieve data from JSON
    $id = $data['id'];
    $logo = $data['logo'];
    $ownername = $data['ownername'];
    $owneridentity = $data['owneridentity'];
    $storename = $data['storename'];
    $email = $data['email'];
    $phonenumber = $data['phonenumber'];
    $country = $data['country'];
    $license = $data['license'];

    // Include your database connection
    include "../login/config.php";

    // Check if the store application already exists in the stores table
    $check_query = "SELECT * FROM stores WHERE id = '$id' AND logo = '$logo' AND ownername = '$ownername' AND owneridentity = '$owneridentity' AND storename = '$storename' AND email = '$email' AND phonenumber = '$phonenumber' AND country = '$country' AND license = '$license'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) == 0) {
        // Insert email, logo, ownername, owneridentity, storename, phonenumber, country, and license into stores table
        $major_insert_query = "INSERT INTO stores(id, logo, ownername, owneridentity, storename, email, phonenumber, country, license) VALUES ('$id', '$logo', '$ownername', '$owneridentity', '$storename', '$email', '$phonenumber', '$country', '$license')";
        if (mysqli_query($conn, $major_insert_query)) {
            echo "Data inserted into stores table successfully. ";
        } else {
            echo "Error inserting data into stores table: " . mysqli_error($conn);
            exit(); // Exit script if an error occurs
        }
    } else {
        echo "Store application already exists for this email. ";
        exit(); // Exit script if store application already exists
    }

    // Delete the row from the database based on ID
    $delete_query = "DELETE FROM storesapplications WHERE id = '$id'";
    if (mysqli_query($conn, $delete_query)) {
        // Row deleted successfully. Add JavaScript to reload the page.
        echo "<script>window.location.reload();</script>";
    } else {
        echo "Error deleting row: " . mysqli_error($conn);
    }

    // Here you can add code to update the confirmation status in your applications table if needed
} else {
    // Data is not properly set, do nothing or log an error
}
?>