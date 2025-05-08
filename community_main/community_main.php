<div class="middle1">
    <div class="stories-slider">
        <div class="story-section">
            <div class="horizontal-scroll">
                <button class="btn-scroll" id="btn-scroll-left" onclick="scrollHorizontally(1)"><i class="fas fa-chevron-left"></i></button>
                <button class="btn-scroll" id="btn-scroll-right" onclick="scrollHorizontally(-1)"><i class="fas fa-chevron-right"></i></button>
                <div class="storys-container">
                    <!-- Circle with + icon for adding a story -->
                    <div class="story-item">
                        <div class="add-story" id="add-story-button">
                            <i class="fas fa-plus"></i>
                        </div>
                        <p class="story-name">Add Story</p>
                    </div>
                    <?php
$unreadColor = "purple"; // Color for unread stories
$readColor = "grey"; // Color for read stories
$emptySectionColor = "rgba(255, 255, 255, 0)"; // Transparent color for empty sections
$solidColor = "purple"; // Solid color for single story

$friends = [];
if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        $friend_email = $row["email"];
        $numPosts = $row["post_count"];

        // Fetch the view status for each story
        $sql_stories = "
            SELECT id, 
                   (SELECT status FROM story_views sv WHERE sv.story_id = s.id AND sv.user_email = ?) AS view_status
            FROM stories s
            WHERE s.email = ?
        ";
        $stmt_stories = $conn->prepare($sql_stories);
        $stmt_stories->bind_param("ss", $user_email, $friend_email);
        $stmt_stories->execute();
        $result_stories = $stmt_stories->get_result();

        // Check if the user has only one post
        if ($numPosts == 1) {
            $story = $result_stories->fetch_assoc();
            $background = $story["view_status"] === 'read' ? $readColor : $solidColor;
        } else {
            $segments = 360 / $numPosts;
            $background = "conic-gradient(from 0deg, ";
            $story_count = 0;
            while ($story = $result_stories->fetch_assoc()) {
                $startAngle = $story_count * $segments;
                $endAngle = $startAngle + $segments;
                $segmentColor = ($story["view_status"] === 'read') ? $readColor : $unreadColor;
                $background .= "{$segmentColor} {$startAngle}deg, {$emptySectionColor} {$endAngle}deg";
                if ($story_count < $numPosts - 1) {
                    $background .= ", ";
                }
                $story_count++;
            }
            $background .= ")";
        }

        echo '<div class="story-item">
                <div class="story-circle" style="background: ' . $background . ';"><img src="profileimg/' . $row["image"] . '" alt="' . $friend_email . '"></div>
                <p class="story-name">' . htmlspecialchars($row["username"]) . '</p>
              </div>';
        $friends[] = $friend_email;
    }
} else {
    echo "No stories found.";
}

$conn->close();
?>


                </div>
            </div>
        </div>
    </div>

<script>
const friends = <?php echo json_encode($friends); ?>;
let currentIndex = 0;
let currentFriendIndex = 0;
let stories = [];
let autoMoveTimeout = null;
let progressInterval = null;
let videoElement = null; // For video reference
let imageContainer = null; // For image container reference

document.querySelectorAll('.story-circle').forEach((circle, index) => {
    circle.addEventListener('click', event => {
        const friendEmail = event.target.alt;
        console.log(`Fetching stories for: ${friendEmail}`);
        currentFriendIndex = index;
        fetchStoryDetails(friendEmail);
    });
});

function fetchStoryDetails(friendEmail) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'community_get_stories.php?friend_email=' + friendEmail, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                const storyDetails = JSON.parse(xhr.responseText);
                console.log(`Fetched stories:`, storyDetails);
                stories = storyDetails;
                currentIndex = 0;
                if (stories.length > 0) {
                    displayStory();
                } else {
                    console.warn('No stories found for this user.');
                    closeFullscreen();
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.error('Response:', xhr.responseText);
                closeFullscreen();
            }
        } else {
            console.error('Error fetching data:', xhr.statusText);
            closeFullscreen();
        }
    };
    xhr.onerror = function() {
        console.error('Request failed');
        closeFullscreen();
    };
    xhr.send();
}

function displayStory() {
    console.log('Current index:', currentIndex);
    console.log('Stories array length:', stories.length);
    console.log('Story at current index:', stories[currentIndex]);

    if (stories.length === 0 || !stories[currentIndex]) {
        console.error('No story to display or invalid index.');
        closeFullscreen();
        return;
    }

    console.log(`Displaying story:`, stories[currentIndex]);

    // Remove any existing fullscreen container
    const existingContainer = document.querySelector('.fullscreen-container');
    if (existingContainer) {
        existingContainer.remove();
    }

    const story = stories[currentIndex];
    const fullscreenContainer = document.createElement('div');
    fullscreenContainer.className = 'fullscreen-container';
    fullscreenContainer.innerHTML = `
        <div class="story-fullscreen">
            <div class="progress-bar-container" id="progress-bar-container">
                ${stories.map((_, index) => `<div class="progress-bar" id="progress-bar-${index}"></div>`).join('')}
            </div>
            <div class="story-header">
                <img src="../profileimg/${story.profile_pic}" alt="${story.name}" class="profile-pic">
                <div class="story-username">${story.name}</div>
            </div>
            ${story.type === 'video' ? 
                `<video src="${story.photo}" controls onloadedmetadata="initVideoProgressBar()" onplay="clearAutoMoveTimeout()" onended="showNextStory()"></video>` : 
                `<img src="${story.photo}" alt="${story.title}" id="image-${currentIndex}">`}
            <button class="prev-btn" onclick="showPreviousStory()">&#10094;</button>
            <button class="next-btn" onclick="showNextStory()">&#10095;</button>
            <button class="close-btn" onclick="closeFullscreen()">&#10006;</button>
        </div>
    `;

    document.body.appendChild(fullscreenContainer);

    fullscreenContainer.addEventListener('click', event => {
        if (event.target === fullscreenContainer) {
            closeFullscreen();
        }
    });

    // Send a request to log the view
    logStoryView(story.id);

    if (story.type === 'video') {
        videoElement = fullscreenContainer.querySelector('video');
        videoElement.play();
        videoElement.onplay = () => {
            startProgressBar(videoElement.duration, currentIndex);
            videoElement.onpause = () => clearInterval(progressInterval);
            videoElement.onended = () => showNextStory();
        };
    } else {
        // Reset the image progress bar
        resetImageProgressBar();
        clearAutoMoveTimeout();
        autoMoveTimeout = setTimeout(() => showNextStory(), 10000); // Auto-move after 10 seconds
    }
}

function logStoryView(storyId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'community_update_story_status.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Story view logged successfully.');
        } else {
            console.error('Error logging story view:', xhr.statusText);
        }
    };
    xhr.onerror = function() {
        console.error('Request failed');
    };
    xhr.send(`story_id=${storyId}`);
}

function initVideoProgressBar() {
    if (videoElement) {
        const progressBarContainer = document.getElementById('progress-bar-container');
        progressBarContainer.innerHTML = `<div class="progress-bar" id="progress-bar-${currentIndex}"></div>`;
        startProgressBar(videoElement.duration, currentIndex);
    }
}

function startProgressBar(duration, index) {
    const progressBar = document.getElementById(`progress-bar-${index}`);
    let width = 0;
    const intervalTime = duration * 10; // Adjust the interval time based on duration
    progressInterval = setInterval(() => {
        if (width >= 100) {
            clearInterval(progressInterval);
        } else {
            width++;
            progressBar.style.width = width + '%';
        }
    }, intervalTime);
}

function resetImageProgressBar() {
    const progressBar = document.getElementById(`progress-bar-${currentIndex}`);
    progressBar.style.width = '0%';
    let width = 0;
    const intervalTime = 100; // 10 seconds
    progressInterval = setInterval(() => {
        if (width >= 100) {
            clearInterval(progressInterval);
        } else {
            width++;
            progressBar.style.width = width + '%';
        }
    }, intervalTime);
}

function clearAutoMoveTimeout() {
    if (autoMoveTimeout) {
        clearTimeout(autoMoveTimeout);
        autoMoveTimeout = null;
    }
}

function showNextStory() {
    currentIndex++;
    if (currentIndex >= stories.length) {
        currentIndex = 0;
        currentFriendIndex++;
        if (currentFriendIndex >= friends.length) {
            currentFriendIndex = 0;
        }
        fetchStoryDetails(friends[currentFriendIndex]);
    } else {
        displayStory();
    }
}

function showPreviousStory() {
    currentIndex--;
    if (currentIndex < 0) {
        currentIndex = 0;
        currentFriendIndex--;
        if (currentFriendIndex < 0) {
            currentFriendIndex = friends.length - 1;
        }
        fetchStoryDetails(friends[currentFriendIndex]);
    } else {
        displayStory();
    }
}

function closeFullscreen() {
    const fullscreenContainer = document.querySelector('.fullscreen-container');
    if (fullscreenContainer) {
        fullscreenContainer.remove();
    }
    clearAutoMoveTimeout();
    clearInterval(progressInterval);
    currentIndex = 0;
    currentFriendIndex = 0;
}
</script>





<script>
    // Add an event listener for the "Add Story" button
document.getElementById('add-story-button').addEventListener('click', function() {
    // Redirect to the "Add Story" page
    window.location.href = '../community_storypost_page/community_storypost_page.php'; // Replace with your actual URL
});

</script>

                <script>
        let currentScrollPosition = 0;
        let scrollAmount = 320;
        
        const sCont = document.querySelector(".storys-container");
        const hScroll = document.querySelector(".horizontal-scroll");
        const btnScrollLeft = document.querySelector("#btn-scroll-left");
        const btnScrollRight = document.querySelector("#btn-scroll-right");
        
        btnScrollLeft.style.opacity = "0";
        
        let maxScroll = -sCont.offsetWidth + hScroll.offsetWidth;
        
        function scrollHorizontally(val) {
            currentScrollPosition += (val * scrollAmount);
        
            if (currentScrollPosition >= 0) {
                currentScrollPosition = 0;
                btnScrollLeft.style.opacity = "0";
            } else {
                btnScrollLeft.style.opacity = "1";
            }
        
            if (currentScrollPosition <= maxScroll) {
                currentScrollPosition = maxScroll;
                btnScrollRight.style.opacity = "0";
            } else {
                btnScrollRight.style.opacity = "1";
            }
        
            sCont.style.left = currentScrollPosition + "px";
        }
        
        // Update maxScroll value when the window is resized
        window.addEventListener('resize', () => {
            maxScroll = -sCont.offsetWidth + hScroll.offsetWidth;
        });

    </script>