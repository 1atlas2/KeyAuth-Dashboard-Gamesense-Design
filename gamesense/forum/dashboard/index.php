<?php
/*
* KEYAUTH.CC PHP EXAMPLE
*
* Edit credentials.php file and enter name & ownerid from https://keyauth.cc/app
*
* READ HERE TO LEARN ABOUT KEYAUTH FUNCTIONS https://github.com/KeyAuth/KeyAuth-PHP-Example#keyauthapp-instance-definition
*
*/
error_reporting(0);

require '../keyauth.php';
require '../credentials.php';

session_start();

if (!isset($_SESSION['user_data'])) // if user not logged in
{
    header("Location: ../");
    exit();
}

$KeyAuthApp = new KeyAuth\api($name, $ownerid);

function findSubscription($name, $list)
{
    for ($i = 0; $i < count($list); $i++) {
        if ($list[$i]->subscription == $name) {
            return true;
        }
    }
    return false;
}

$username = $_SESSION["user_data"]["username"];
$subscriptions = $_SESSION["user_data"]["subscriptions"];
$subscription = $_SESSION["user_data"]["subscriptions"][0]->subscription;
$expiry = $_SESSION["user_data"]["subscriptions"][0]->expiry;

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: ../");
    exit();
}
?>
<html lang="en">

<head>
    <title>Dashboard</title>
    <style>
        body {
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    background-color: rgba(21, 21, 20, 1);
    font-family: "Clobber Grotesk Light", sans-serif;
    overflow: hidden;
      overflow-y: scroll;
            scrollbar-color: rgb(106, 188, 20) black; /* Farbe der Scrollbar */
            scrollbar-width: thin; /* Breite der Scrollbar */
             background-image: url('hd-dark-aesthetic-csgo-6gcqmzhaajkk8aue1.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
  }
  
  .color-bar {
    width: 100%;
    height: 3px;
    background: linear-gradient(to right, rgb(255, 0, 0), rgb(0, 255, 0), rgb(0, 0, 255));
  }
  nav {
        list-style-type: none;
        padding: 0;
        display: flex;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.7);
        width: 100%;
    }

    nav ul {
        list-style-type: none;
        display: flex;
        justify-content: center;
    }

    nav li {
        margin: 10px;
    }

    nav a {
        text-decoration: none;
        color: white;
        font-weight: 500;
        transition: color 0.3s;
    }

    nav a:hover {
        color: rgb(106, 188, 20);
    }
     .black-card {
            background-color: black;
            color: white;
            width: 80%;
            margin-top: 10px; 
            padding: 20px;
            border-radius: 5px;
            font-family: "Clobber Grotesk Light", sans-serif;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative; 
        }

       
        .card-header {
            position: absolute;
            top: -5px; 
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right, rgb(255, 0, 0), rgb(0, 255, 0), rgb(0, 0, 255));
            border-radius: 5px 5px 0 0; 
        }

       
        .newsbox-card {
            background-color: black;
            color: white;
            width: 80%;
            margin-top: 20px;
            padding: 20px;
            border-radius: 5px;
            font-family: "Clobber Grotesk Light", sans-serif;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .newsbox-username {
            color: rgb(106, 188, 20);
        }
        .newsbox-title {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .profile-card {
            background-color: black;
            color: white;
            width: 80%;
            margin-top: 20px;
            padding: 30px; /* Mehr Platz für den Inhalt */
            border-radius: 5px;
            font-family: "Clobber Grotesk Light", sans-serif;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }
        .profile-card-header {
            position: absolute;
            top: -5px; 
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(to right, rgb(255, 0, 0), rgb(0, 255, 0), rgb(0, 0, 255));
            border-radius: 5px 5px 0 0; 
        }
        .profile-card-title {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .green-button {
            background-color: rgb(106, 188, 20);
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            display: inline-block; 
            text-decoration: none;
            width: fit-content;
            margin: 10px; 
        }
        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }
        .expiry-date {
            font-size: 18px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
        }
        .modal-content {
            background-color: black;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid rgb(106, 188, 20);
            width: 80%;
            max-width: 600px;
            border-radius: 5px;
            color: white;
            position: relative;
            animation: fadeIn 0.3s ease;
        }
        .close {
            color: white;
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 24px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: rgb(106, 188, 20);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
         .button-container {
   text-align: center;
    margin-top: 20px;
}
    </style>
    <script src="https://cdn.keyauth.cc/dashboard/unixtolocal.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
     <div class="color-bar"></div>
     <nav>
    <ul>
        <li><a href="https://domain.xyz/gamesense/index.html">Home</a></li>
         <li><a href="https://domain.xyz/gamesense/forum/upgrade/index.php">Renew Subscription</a></li>
    </ul>
</nav>
<br><br>
  <div class="black-card">
        <div class="card-header"></div>
        <p>Hello, and welcome back <span class="newsbox-username"><?php echo $username; ?></span>.</p>
    </div>
    <div class="newsbox-card">
        <div class="card-header"></div>
        <h2 class="newsbox-title"><i class="fas fa-newspaper"></i> News</h2> 
        <p><span class="newsbox-username"><?php echo $username; ?></span>: New Version 1.67 Released for the Product Rainbow Six Siege *Posted at 23/08/2023* </p>
    </div>
     <div class="profile-card">
        <div class="profile-card-header"></div> 
        <h2 class="profile-card-title"><i class="fas fa-user-circle"></i> User Account Management</h2>
        <img class="profile-picture" src="standard-profile-picture.jpg" alt="Profile Picture">
        <p><span class="newsbox-username"><?php echo $username; ?></span></p>
        <p class="expiry-date"><span style="color: white;">Subscription Expires at:</span>&nbsp;<span style="color: rgb(106, 188, 20);"><?php echo date("F j, Y, g:i a", $expiry); ?></span></p>
        <div class="button-container">
    <button class="green-button" onclick="openRenewalGuide()"><i class="fas fa-credit-card"></i> Renew Subscription</button>
    <a href="#" class="green-button"><i class="fas fa-download"></i> Download</a>
</div>
<form method="post">
    <button name="logout" class="green-button"><i class="fas fa-sign-out-alt"></i> Logout</button>
</form>
    </div>
     <div id="renewal-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRenewalGuide()">&times;</span>
            <h2>Guide to Renew Subscription</h2>
            <ol>
                <li>Logout</li>
                <li>Go to the link <a href="https://domain.xyz/gamesense/forum/upgrade/index.php">https://siresware.xyz/gamesense/forum/upgrade/index.php</a></li>
                <li>Enter your Username and License</li>
            </ol>
            <form method="post">
                <button name="logout" class="green-button"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>
     <script>
       function openRenewalGuide() {
            var modal = document.getElementById("renewal-modal");
            modal.style.display = "block";
        }

        function closeRenewalGuide() {
            var modal = document.getElementById("renewal-modal");
            modal.style.display = "none";
        }
    </script>
</body>
</html>