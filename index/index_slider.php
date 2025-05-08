<?php
include '../login/config.php';
// Fetch data from slider_sales table
$sql = "SELECT id, image, title1, title2, subtitle, button_text, button_link FROM slider_sales";
$result = $conn->query($sql);
?>

<div class="slider">
    <div class="container">
        <div class="wrapper">
            <div class="myslider swiper">
                <div class="swiper-wrapper">
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo '<div class="swiper-slide">
                                    <div class="item">
                                        <div class="image object-cover">
                                            <img src="../admin/slider_images/' . $row["image"] . '" alt="">
                                        </div>
                                        <div class="text-content flexcol">
                                            <h4>' . $row["subtitle"] . '</h4>
                                            <h2><span>' . $row["title1"] . '</span><br><span>' . $row["title2"] . '</span></h2>
                                            <a href="' . $row["button_link"] . '" class="primary-button">' . $row["button_text"] . '</a>
                                        </div>
                                    </div>
                                  </div>';
                        }
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                    ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
</div>
