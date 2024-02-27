<!DOCTYPE html>
<html>
<head>
    <title>Fetcher</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f2f2f2;
        }
        
        .container {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .input-container {
            margin-bottom: 20px;
        }

        #argument {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            margin-top: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            background-color: #F217EB;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #CD2AC8;
        }

        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .user-info p {
            margin: 5px 0;
        }

        .count {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="input-container">
            <form action="#" method="GET">
                <input type="text" id="argument" name="argument" placeholder="Enter Username" style="width: 90%">
                <button type="submit">Submit</button>
            </form>
        </div>

        <?php
        if(isset($_GET['argument'])){
            $argument = $_GET['argument'];
            
            $escapedArgument = escapeshellarg($argument);
            
            $command = "python3 igfetcher.py " . $escapedArgument;
            $output = shell_exec($command);
            
            $lines = explode("\n", $output);
            // print_r($lines);

            if(count($lines) < 3) {
                echo '<div class="not_found">';
                echo '<h3>No such user on Instagram, Try Again</h3>';
                echo '</div>';
                return;
            } else {
                foreach ($lines as $index => $line) {
                    if (strpos($line, "Avatar Image:") === 0) {
                        $profilePic = trim(str_replace("Avatar Image:", "", $lines[$index]));
                        $proxyURL = "https://images.weserv.nl/?url=" . urlencode($profilePic);
                        break;
                    }
                }
                foreach ($lines as $index => $line) {
                    if (strpos($line, "User Handle:") === 0) {
                        $userhandle = trim(str_replace("User Handle:", "", $lines[$index]));
                        break;
                    }
                }
                foreach ($lines as $index => $line) {
                    if (strpos($line, "Display Name:") === 0) {
                        $username = trim(str_replace("Display Name:", "", $lines[$index]));
                        break;
                    }
                }
                foreach ($lines as $index => $line) {
                    if (strpos($line, "Follower Count:") === 0) {
                        $followers = trim(str_replace("Follower Count:", "", $lines[$index]));
                        break;
                    }
                }
                foreach ($lines as $index => $line) {
                    if (strpos($line, "Following Count:") === 0) {
                        $following = trim(str_replace("Following Count:", "", $lines[$index]));
                        break;
                    }
                }
                foreach ($lines as $index => $line) {
                    if (strpos($line, "Post Count:") === 0) {
                        $posts = trim(str_replace("Post Count:", "", $lines[$index]));
                        break;
                    }
                }
                foreach ($lines as $index => $line) {
                    if (strpos($line, "User Bio:") === 0) {
                        $bio = trim(str_replace("User Bio:", "", $lines[$index]));
                        break;
                    }
                }
                
                echo '<div class="output-container">';
                echo '<img class="profile-pic" src="' . $proxyURL . '" alt="Profile Picture">';
                echo '<div class="user-info">';
                echo '<p class="name">' . $username . '</p>';
                echo '<p class="bio">' . $bio . '</p>';
                echo '</div>';
                echo '<div class="count">';
                echo '<p class="ercount">' . $followers . ' <strong>Followers</strong></p>';
                echo '<p class="ingcount">' . $following . ' <strong>Following</strong></p>';
                echo '<p class="pcount">' . $posts . ' <strong>Posts</strong></p>';
                echo '</div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</body>
</html>