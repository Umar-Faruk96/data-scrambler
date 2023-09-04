<?php
	require_once __DIR__ . '/../../bootstrap.php';
?>
<div>
    <div class="float-left">
        <p>
            <a href="/hasin haider/projects/CRUD/index.php?task=report">All Students</a> |
            <a href="/hasin haider/projects/CRUD/index.php?task=add">Add New Student</a> |
            <a href="/hasin haider/projects/CRUD/index.php?task=seed">Seed</a>
        </p>
    </div>
    <div class='float-right'>
		 <?php
			 if ($_SESSION['loggedIn']) {
				 // Show the "Log Out" link
				 ?>
              <a href="/hasin haider/projects/CRUD/auth.php?logOut=true">Log Out</a>
				 <?php
			 } else {
				 // Show the "Log In" link
				 ?>
              <a href="/hasin haider/projects/CRUD/auth.php">Log In</a>
				 <?php
			 }
		 ?>
    </div>
</div>