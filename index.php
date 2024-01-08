<!DOCTYPE html>
<html>
<head>
    <title>yourT</title>
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
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #0056b3;
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
            <form action="" method="GET">
                <input type="text" id="argument" name="argument" placeholder="Enter Username" style="width: 90%">
                <button type="submit">Submit</button>
            </form>
        </div>

        <?php
        if(isset($_GET['argument'])){
            $argument = $_GET['argument'];
            
            // Escaping the argument to prevent command injection
            $escapedArgument = escapeshellarg($argument);
            
            // Executing the Python script with the user input as an argument
            $command = "python3 tfetcher.py " . $escapedArgument;
            $output = shell_exec($command);
            
            // Processing the output
            $lines = explode("\n", $output);
            
            $profilePic = trim(str_replace("Avatar Image:", "", $lines[0]));
            $userhandle = trim(str_replace("User Handle:", "", $lines[1]));
            $username = trim(str_replace("Username:", "", $lines[2]));
            $bio = trim(str_replace("User Bio:", "", $lines[3]));
            $followers = trim(str_replace("Follower Count:", "", $lines[4]));
            $following = trim(str_replace("Following Count:", "", $lines[5]));
            $tweets = trim(str_replace("Tweets Count:", "", $lines[6]));
            
            // Outputting the results
            echo '<div class="output-container">';
            echo '<img class="profile-pic" src="' . $profilePic . '" alt="Profile Picture">';
            echo '<div class="user-info">';
            echo '<p>' . $username . '</p>';
            echo '<p>' . $bio . '</p>';
            echo '</div>';
            echo '<div class="count">';
            echo '<p>' . $followers . ' <strong>Followers</strong></p>';
            echo '<p>' . $following . ' <strong>Following</strong></p>';
            echo '<p>' . $tweets . ' <strong>Tweets</strong></p>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>