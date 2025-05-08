<?php
include "../login/config.php";

// Query to count products for each category
$query = "SELECT category_id, COUNT(product_id) AS product_count FROM product_categories GROUP BY category_id";
$result = mysqli_query($conn, $query);

// Create an array to store the category counts
$category_counts = array();

while ($row = mysqli_fetch_assoc($result)) {
    $category_counts[$row['category_id']] = $row['product_count'];
}

// Close the database connection
mysqli_close($conn);
?>
        <div class="single-category">
            <div class="container">
                <div class="wrapper">
                    <div class="column">
                        <div class="holder">
                            <div class="row sidebar">
                                <div class="filter">
                                    <div class="filter-block">
                                        <form action="" method="get" id="categoryForm">
                                        <ul>
                                                <li>
                                                    <label onclick="updateCategory('1');">
                                                        <span class="category-name">Skincare</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['1'])? $category_counts['1'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('2');">
                                                        <span class="category-name">Makeup</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['2'])? $category_counts['2'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('3');">
                                                        <span class="category-name">Home Decor</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['3'])? $category_counts['3'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('4');">
                                                        <span class="category-name">Breakfast</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['4'])? $category_counts['4'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('5');">
                                                        <span class="category-name">Pantry</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['5'])? $category_counts['5'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('6');">
                                                        <span class="category-name">Dining Room</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['6'])? $category_counts['6'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('7');">
                                                        <span class="category-name">Kitchen</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['7'])? $category_counts['7'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('8');">
                                                        <span class="category-name">Electronics</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['8'])? $category_counts['8'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('9');">
                                                        <span class="category-name">Headphones</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['9'])? $category_counts['9'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('10');">
                                                        <span class="category-name">Computers</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['10'])? $category_counts['10'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('11');">
                                                        <span class="category-name">Cellphones</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['11'])? $category_counts['11'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('12');">
                                                        <span class="category-name">TV</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['12'])? $category_counts['12'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('13');">
                                                        <span class="category-name">Camera</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['13'])? $category_counts['13'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('14');">
                                                        <span class="category-name">Beauty</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['14'])? $category_counts['14'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('15');">
                                                        <span class="category-name">Foot & Hand Care</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['15'])? $category_counts['15'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('16');">
                                                        <span class="category-name">Accessories</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['16'])? $category_counts['16'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('17');">
                                                        <span class="category-name">Hair Care</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['17'])? $category_counts['17'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('19');">
                                                        <span class="category-name">Women</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['19'])? $category_counts['19'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('20');">
                                                        <span class="category-name">Men</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['20'])? $category_counts['20'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('21');">
                                                        <span class="category-name">Girl</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['21'])? $category_counts['21'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('22');">
                                                        <span class="category-name">Boy</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['22'])? $category_counts['22'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('23');">
                                                        <span class="category-name">Health</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['23'])? $category_counts['23'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('24');">
                                                        <span class="category-name">Home</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['24'])? $category_counts['24'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('25');">
                                                        <span class="category-name">Pet</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['25'])? $category_counts['25'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('26');">
                                                        <span class="category-name">Sports</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['26'])? $category_counts['26'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('27');">
                                                        <span class="category-name">Shave</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['27'])? $category_counts['27'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('28');">
                                                        <span class="category-name">Personal Care</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['28'])? $category_counts['28'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('29');">
                                                        <span class="category-name">Home Audio</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['29'])? $category_counts['29'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('30');">
                                                        <span class="category-name">Wearable Technology</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['30'])? $category_counts['30'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('31');">
                                                        <span class="category-name">Women Clothing</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['31'])? $category_counts['31'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('32');">
                                                        <span class="category-name">Women Shoes</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['32'])? $category_counts['32'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('33');">
                                                        <span class="category-name">Women Jewelry</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['33'])? $category_counts['33'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('34');">
                                                        <span class="category-name">Women Watches</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['34'])? $category_counts['34'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('35');">
                                                        <span class="category-name">Women Handbags</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['35'])? $category_counts['35'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('36');">
                                                        <span class="category-name">Women Accessories</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['36'])? $category_counts['36'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('37');">
                                                        <span class="category-name">Men Clothing</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['37'])? $category_counts['37'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('38');">
                                                        <span class="category-name">Men Shoes</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['38'])? $category_counts['38'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('39');">
                                                        <span class="category-name">Men Suits</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['39'])? $category_counts['39'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('40');">
                                                        <span class="category-name">Men Watches</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['40'])? $category_counts['40'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('41');">
                                                        <span class="category-name">Men Wallets</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['41'])? $category_counts['41'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('42');">
                                                        <span class="category-name">Men Shorts</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['42'])? $category_counts['42'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('43');">
                                                        <span class="category-name">Men Coats</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['43'])? $category_counts['43'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('44');">
                                                        <span class="category-name">Men Belts</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['44'])? $category_counts['44'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('45');">
                                                        <span class="category-name">Men Sunglasses</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['45'])? $category_counts['45'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('46');">
                                                        <span class="category-name">Men Shaving</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['46'])? $category_counts['46'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('47');">
                                                        <span class="category-name">Men Gym</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['47'])? $category_counts['47'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('48');">
                                                        <span class="category-name">Girl Clothing</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['48'])? $category_counts['48'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('49');">
                                                        <span class="category-name">Girl Dresses</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['49'])? $category_counts['49'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('50');">
                                                        <span class="category-name">Girl Jackets</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['50'])? $category_counts['50'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('51');">
                                                        <span class="category-name">Girl Watches</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['51'])? $category_counts['51'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('52');">
                                                        <span class="category-name">Girl Bags</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['52'])? $category_counts['52'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('53');">
                                                        <span class="category-name">Girl Hats</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['53'])? $category_counts['53'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('54');">
                                                        <span class="category-name">Girl Underwear</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['54'])? $category_counts['54'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('55');">
                                                        <span class="category-name">Girl Makeup</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['55'])? $category_counts['55'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('56');">
                                                        <span class="category-name">Girl Sunglasses</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['56'])? $category_counts['56'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('57');">
                                                        <span class="category-name">Girl Shoes</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['57'])? $category_counts['57'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('58');">
                                                        <span class="category-name">Girl Skincare</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['58'])? $category_counts['58'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('59');">
                                                        <span class="category-name">Boy Clothing</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['59'])? $category_counts['59'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('60');">
                                                        <span class="category-name">Boy Shirts</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['60'])? $category_counts['60'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('61');">
                                                        <span class="category-name">Boy Jackets</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['61'])? $category_counts['61'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('62');">
                                                        <span class="category-name">Boy Watches</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['62'])? $category_counts['62'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('63');">
                                                        <span class="category-name">Boy Wallets</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['63'])? $category_counts['63'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('64');">
                                                        <span class="category-name">Boy Hats</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['64'])? $category_counts['64'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('65');">
                                                        <span class="category-name">Boy Underwear</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['65'])? $category_counts['65'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('66');">
                                                        <span class="category-name">Boy Sunglasses</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['66'])? $category_counts['66'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('67');">
                                                        <span class="category-name">Boy Shoes</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['67'])? $category_counts['67'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('68');">
                                                        <span class="category-name">Living Room</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['68'])? $category_counts['68'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('69');">
                                                        <span class="category-name">Family Room</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['69'])? $category_counts['69'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('70');">
                                                        <span class="category-name">Sunroom</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['70'])? $category_counts['70'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('71');">
                                                        <span class="category-name">Bathroom</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['71'])? $category_counts['71'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('72');">
                                                        <span class="category-name">Bedroom</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['72'])? $category_counts['72'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('73');">
                                                        <span class="category-name">Storage</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['73'])? $category_counts['73'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('74');">
                                                        <span class="category-name">Closet</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['74'])? $category_counts['74'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('75');">
                                                        <span class="category-name">Baby</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['75'])? $category_counts['75'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('76');">
                                                        <span class="category-name">Laundry</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['76'])? $category_counts['76'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('77');">
                                                        <span class="category-name">Garage</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['77'])? $category_counts['77'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('78');">
                                                        <span class="category-name">Pool</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['78'])? $category_counts['78'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('79');">
                                                        <span class="category-name">Backyard</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['79'])? $category_counts['79'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('80');">
                                                        <span class="category-name">Porch</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['80'])? $category_counts['80'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('81');">
                                                        <span class="category-name">Exterior</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['81'])? $category_counts['81'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('82');">
                                                        <span class="category-name">Outdoor</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['82'])? $category_counts['82'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('83');">
                                                        <span class="category-name">Pet Food</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['83'])? $category_counts['83'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('84');">
                                                        <span class="category-name">Pet Supplies</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['84'])? $category_counts['84'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('85');">
                                                        <span class="category-name">Pet Toys</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['85'])? $category_counts['85'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('86');">
                                                        <span class="category-name">Sport Balls</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['86'])? $category_counts['86'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('87');">
                                                        <span class="category-name">Sport Helmets</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['87'])? $category_counts['87'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('88');">
                                                        <span class="category-name">Sport Treadmills</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['88'])? $category_counts['88'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('89');">
                                                        <span class="category-name">Fishing</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['89'])? $category_counts['89'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('90');">
                                                        <span class="category-name">Gym Bag</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['90'])? $category_counts['90'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('91');">
                                                        <span class="category-name">Sport Clothes</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['91'])? $category_counts['91'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('92');">
                                                        <span class="category-name">Sport Shoes</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['92'])? $category_counts['92'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('93');">
                                                        <span class="category-name">Dresses</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['93'])? $category_counts['93'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('94');">
                                                        <span class="category-name">Tops</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['94'])? $category_counts['94'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('95');">
                                                        <span class="category-name">Jackets</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['95'])? $category_counts['95'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('96');">
                                                        <span class="category-name">Sweaters</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['96'])? $category_counts['96'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('97');">
                                                        <span class="category-name">Hoodies</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['97'])? $category_counts['97'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('98');">
                                                        <span class="category-name">Pajamas</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['98'])? $category_counts['98'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('99');">
                                                        <span class="category-name">Shorts</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['99'])? $category_counts['99'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('100');">
                                                        <span class="category-name">Swimwear</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['100'])? $category_counts['100'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('101');">
                                                        <span class="category-name">Pants</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['101'])? $category_counts['101'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('102');">
                                                        <span class="category-name">Bags</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['102'])? $category_counts['102'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('103');">
                                                        <span class="category-name">Necklace</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['103'])? $category_counts['103'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('104');">
                                                        <span class="category-name">Rings</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['104'])? $category_counts['104'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('105');">
                                                        <span class="category-name">Earrings</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['105'])? $category_counts['105'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('106');">
                                                        <span class="category-name">Bracelets</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['106'])? $category_counts['106'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('107');">
                                                        <span class="category-name">Jewelry</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['107'])? $category_counts['107'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('108');">
                                                        <span class="category-name">Bath</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['108'])? $category_counts['108'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('109');">
                                                        <span class="category-name">Soaps</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['109'])? $category_counts['109'] : 0;?></span>
                                                </li>
                                                <li>
                                                    <label onclick="updateCategory('110');">
                                                        <span class="category-name">Face Masks</span>
                                                    </label>
                                                    <span class="count"><?php echo isset($category_counts['110'])? $category_counts['110'] : 0;?></span>
                                                </li>
                                                <!-- Add more categories here as needed -->
                                            </ul>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </form>

