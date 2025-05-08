<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['order_number']) && isset($_SESSION['email'])) {
        $orderNumber = $data['order_number'];
        $email = $_SESSION['email'];

include "../login/config.php";

        // Start transaction
        $conn->begin_transaction();

        try {
            // Move the item from pending to refunded table with all fields
            $move_query = "INSERT INTO refunded (
                id, email, product_id, order_number, image, name, price, qty, subtotal, email_address,
                first_name, last_name, street_address, country, state, town, zip_code, phone_number, payment_method,
                visa_card_name, visa_card_number, visa_expiry_date, visa_cvv, master_card_name, master_card_number,
                master_expiry_date, master_cvv, wish_image, status, size, sizenumber
            ) SELECT 
                id, email, product_id, order_number, image, name, price, qty, subtotal, email,
                first_name, last_name, street_address, country, state, town, zip_code, phone_number, payment_method,
                visa_card_name, visa_card_number, visa_expiry_date, visa_cvv, master_card_name, master_card_number,
                master_expiry_date, master_cvv, wish_image, status, size, sizenumber
            FROM pending WHERE order_number = ? AND email = ?";

            $stmt_move = $conn->prepare($move_query);
            $stmt_move->bind_param("ss", $orderNumber, $email);
            $stmt_move->execute();

            if ($stmt_move->affected_rows > 0) {
                // Delete the item from pending table
                $delete_query = "DELETE FROM pending WHERE order_number = ? AND email = ?";
                $stmt_delete = $conn->prepare($delete_query);
                $stmt_delete->bind_param("ss", $orderNumber, $email);
                $stmt_delete->execute();

                if ($stmt_delete->affected_rows > 0) {
                    // Commit transaction
                    $conn->commit();
                    echo json_encode(['success' => true, 'message' => 'Item has been refunded successfully.']);
                } else {
                    // Rollback transaction
                    $conn->rollback();
                    echo json_encode(['success' => false, 'message' => 'Failed to delete item from pending table.']);
                }
            } else {
                // Rollback transaction
                $conn->rollback();
                echo json_encode(['success' => false, 'message' => 'Failed to move item to refunded table.']);
            }

            // Close statements
            $stmt_move->close();
            $stmt_delete->close();
        } catch (Exception $e) {
            // Rollback transaction
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
        }

        // Close connection
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
