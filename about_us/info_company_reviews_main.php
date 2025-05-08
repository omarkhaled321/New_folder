<div class="related-products"> 
            <div class="container">
                <div class="wrapper">
                    <div class="column">
                    <style>

        .containerinfo {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .containerinfo h1,
        .containerinfo h2,
        .containerinfo h3 {
            color: #333;
            text-align: center;
        }
        .review-item {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .review-author {
            font-weight: bold;
        }
        .review-date {
            color: #888;
        }
        .review-content {
            margin-top: 10px;
            color: #666;
        }
        .add-review-form {
            margin-top: 20px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group textarea {
            width: 100%;
            min-height: 100px;
            padding: 5px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        .form-group input[type="submit"] {
            padding: 8px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #555;
        }
    </style>

<!-- Add Review Form -->
<div class="add-review-form">
    <h2>Add Your Review</h2>
    <form id="reviewForm" method="post" action="submit_review.php">
        <div class="form-group">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="content">Your Review</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Submit Review">
        </div>
    </form>
</div>
<div class="container">
        <h1>Customer Reviews</h1>

        <!-- PHP to fetch and display reviews from the database -->
        <?php
        // Database connection details
        include "../login/config.php";

        // Fetch reviews from the database
        $sql = "SELECT name, content, time FROM companyreviews ORDER BY time DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<div class="review-item">';
                echo '<div class="review-header">';
                echo '<span class="review-author">' . htmlspecialchars($row["name"]) . '</span>';
                echo '<span class="review-date">' . date("F j, Y", strtotime($row["time"])) . '</span>';
                echo '</div>';
                echo '<div class="review-content">';
                echo '<p>' . htmlspecialchars($row["content"]) . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No reviews yet.";
        }

        $conn->close();
        ?>
    </div>
        
    </div>

                    </div>
                </div>
            </div>
