<?php
include '../login/config.php';
// Check if the search query parameter is provided
if (isset($_GET['query'])) {
    // Sanitize the search query to prevent SQL injection
    $searchQuery = mysqli_real_escape_string($conn, $_GET['query']);

    // Query to search for products whose names match or partially match the search query
    $sql = "SELECT * FROM products WHERE name LIKE '%$searchQuery%'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Array to store the search results
        $searchResults = [];

        // Fetch rows from the result set
        while ($row = mysqli_fetch_assoc($result)) {
            $searchResults[] = $row;
        }

        // Close the database connection
        mysqli_close($conn);

        // Return the search results as JSON
        echo json_encode($searchResults);
    } else {
        echo json_encode(['error' => 'Failed to execute query']);
    }
} else {
    echo json_encode(['error' => 'Search query parameter not provided']);
}
?>
