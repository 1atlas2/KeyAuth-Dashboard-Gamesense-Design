<?php
require '../credentials.php';
require '../keyauth.php';

if (session_status() === PHP_SESSION_NONE) {
	session_start();
}

if (isset($_SESSION['un'])) {
	header("Location: ../dashboard/");
	exit();
}

$KeyAuthApp = new KeyAuth\api($name, $OwnerId);

if (!isset($_SESSION['sessionid'])) {
	$KeyAuthApp->init();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">

	<?php
	echo '
	    <title>KeyAuth - Upgrade Account</title>
	    <meta name="og:image" content="https://cdn.keyauth.cc/front/assets/img/favicon.png">
        <meta name="description" content="Upgrade your account in  ' . $name . '">
        ';
	?>

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">


<style>
         body {
        background-color: rgba(21, 21, 20, 255);
        font-family: 'Clobber Grotesk Light', sans-serif;
        color: white;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start; /* Align content at the top */
        height: 100vh;
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
    .container {
        background-color: rgba(0, 0, 0, 0.8);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        max-width: 400px;
        text-align: center;
        backdrop-filter: blur(10px);
        width: 100%;
        margin-top: 20px;
    }
    .input-group {
        margin: 10px 0;
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-group input {
        flex: 1;
        padding: 10px;
        border: none;
        background-color: rgba(0, 0, 0, 0.2);
        color: white;
        border-radius: 5px;
    }
        .input-group label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
        }
        .input-group input:focus + label,
        .input-group input:valid + label {
            top: 0;
            transform: translateY(0);
            font-size: 12px;
            background-color: rgba(0, 0, 0, 0.3); 
            padding: 5px;
        }
        .button-group {
            margin-top: 20px;
        }
        .button-group button {
            flex: 1;
            padding: 10px;
            border: none;
            background-color: #6abc14;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .button-group button:hover {
            background-color: #4b8e0b;
        }
        .create-account {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        .create-account:hover {
            color: rgb(106, 188, 20);
        }
        .sign-in-title {
            font-size: 24px;
            margin-bottom: 10px;
            color: white;
        }
        .name-part {
            color: rgb(106, 188, 20);
        }
    </style>
	<script type="text/javascript">
		if (window.history.replaceState) {
			window.history.replaceState(null, null, window.location.href);
		}
	</script>
</head>
<body>
   <div class="color-bar"></div>
     <nav>
    <ul>
        <li><a href="https://domain.xyz/gamesense/index.php">Home</a></li>
        <li><a href="https://domain.xyz/gamesense/forum/dashboard/index.php">Panel</a></li>
         <li><a href="https://domain.xyz/gamesense/forum/register/index.php">Register</a></li>
    </ul>
</nav>
    <div class="container">
        <h1 class="sign-in-title">Upgrade for</h1>
        <h2>game<span class="name-part">sense</span> Panel</h2>
        <form method="post">
            <div class="input-group">
                <input type="text" name="username" required autocomplete="off">
                <label>Username</label>
            </div>
            <div class="input-group">
                <input type="text" name="license" required autocomplete="off">
                <label>License</label>
            </div>
            <div class="button-group">
                <button name="login">Continue</button>
            </div>
        </form>
        <p>New Here? <a href="./register/" class="create-account">Create an Account</a></p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
	<?php
	if (isset($_POST['upgrade'])) {
		if ($KeyAuthApp->upgrade($_POST['username'], $_POST['license'])) {
			echo '
                        <script type=\'text/javascript\'>
                        
                        const notyf = new Notyf();
                        notyf
                          .success({
                            message: \'Upgraded Successfully! Now login please.\',
                            duration: 3500,
                            dismissible: true
                          });                
                        
                        </script>
                        ';
		}
	}
	?>
</body>
</html>