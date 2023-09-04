<?php
	declare(strict_types=1);
	require_once 'bootstrap.php';
 
	$logInError = false;
	
	$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	
	$filepath = fopen("./data/users.txt", 'r');
	
	if ($username && $password) {
		$_SESSION['loggedIn'] = false;
		$_SESSION['user'] = false;
		#var_dump($username, $password);
		#var_dump($_SESSION);
		#var_dump($filepath);
		
		while ($data = fgetcsv($filepath)) {
			
			if ($data[0] === $username && $data[1] === sha1($password)) {
				$_SESSION['loggedIn'] = true;
				$_SESSION['user'] = $username;
				#var_dump($_SESSION);
				header('location:/hasin haider/projects/CRUD/index.php');
			}
			
			if (!$_SESSION['loggedIn']) {
				$logInError = true;
			}
		}
		#var_dump($logInError);
	}
	if (isset($_GET['logOut'])) {
		$_SESSION['loggedIn'] = false;
		$_SESSION['user'] = false;
		session_destroy();
		header('location:/hasin haider/projects/CRUD/index.php');
	}
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>User Authentication</title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css'>
    <style>
        body {
            margin-top: 30px;
        }
    </style>
</head>

<body>
<div class='container'>
    <div class='row'>
        <div class='column column-60 column-offset-20'>
            <h2>User Authentication</h2>
        </div>
    </div>
    <div class="row">
        <div class="column column-60 column-offset-20">
			  <?php
				  if ($_SESSION['loggedIn']) {
					  echo '<p>Hello Admin, Welcome!</p>';
				  } else {
					  echo '<p>Hello Stranger, Login Below</p>';
				  }
			  ?>
        </div>
    </div>
    <div class="row">
        <div class="column column-60 column-offset-20">
			  <?php
				  if ($logInError) {
					  echo "<pre>Username and Password didn't match</pre>";
				  }
				  // ! login form
				  if (!$_SESSION['loggedIn']):
					  ?>
                  <form action="auth.php" method="post">
                      <label for='username'>Username</label>
                      <input type='text' name='username' id='username'>
                      <label for='password'>Password</label>
                      <input type='password' name='password' id='password'>
                      <button type="submit" class="button-primary" name="submit">Log In</button>
                  </form>
				  <?php
				  else:
					  // ! logout form
					  ?>
                  <form action='auth.php?logOut=true' method='post'>
                      <input type="hidden" name="logOut" value="1">
                      <button type='submit' class='button-primary' name='submit'>Log Out</button>
                  </form>
				  <?php
				  endif;
			  ?>
        </div>
    </div>
</div>
</body>

</html>