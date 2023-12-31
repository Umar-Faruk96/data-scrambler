<?php
	declare(strict_types=1);
	require_once "inc/functions.php";
	require_once 'bootstrap.php';
	
	$seedInfo = '';
	$taskHolder = $_GET['task'] ?? 'report';
	$taskError = $_GET['error'] ?? 'not found';
	
	# seed mechanism
	if ('seed' === $taskHolder) {
		seed(DATABASE_FILE);
		$seedInfo = "Seeding is completed";
	}
	
	#add and update student logic
	if (isset($_POST['submit'])) {
		$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$roll = filter_input(INPUT_POST, 'roll', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		if (!empty($id)) {
			# update existing student
			if ($firstName !== '' && $lastName !== '' && $roll !== '') {
				$studentUpdated = updateStudent(DATABASE_FILE, $id, $firstName, $lastName, $roll);
				if ($studentUpdated) {
					header('location:/hasin haider/projects/CRUD/index.php?task=report');
				} else {
					$taskError = 'found';
				}
			}
		} else {
			# add new student
			if ($firstName !== '' && $lastName !== '' && $roll !== '') {
				$studentAdded = addStudent(DATABASE_FILE, $firstName, $lastName, $roll);
				if ($studentAdded) {
					header('location:/hasin haider/projects/CRUD/index.php?task=report');
				} else {
					$taskError = 'found';
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Project</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">

    <style>
        body, div {
            margin-top: 20px;
        }
    </style>
    <script src='assets/js/script.js' type='application/javascript'></script>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="column column-60 column-offset-20">
            <h2>Project 2 - CRUD</h2>
            <p>A sample project to perform CRUD operations using plain files and PHP</p>
			  <?php include_once 'inc/templates/nav.php' ?>
            <hr>
			  <?php
				  if ($seedInfo !== '') {
					  echo "<p>$seedInfo</p>";
				  }
			  ?>
        </div>
    </div>

    <!--   duplicate roll found output-->
	<?php if ("found" === $taskError) : ?>
       <div class="row">
           <div class="column column-60 column-offset-20">
               <blockquote>Duplicate Roll Number Found</blockquote>
           </div>
       </div>
	<?php endif; ?>

    <!--   generate report output-->
	<?php if ("report" === $taskHolder) : ?>
       <div class="row">
           <div class="column column-60 column-offset-20">
				  <?php generateReport(DATABASE_FILE); ?>
               <!--<pre>
                     <?php /*printRaw(DATABASE_FILE) */ ?>
               </pre>-->
           </div>
       </div>
	<?php endif; ?>

    <!--   add student form output-->
	<?php if ("add" === $taskHolder) : ?>
       <div class="row">
           <div class="column column-60 column-offset-20">
               <form action="/hasin haider/projects/CRUD/index.php?task=add" method="post">
                   <label for="firstName">First Name</label>
                   <input type="text" name="firstName" id="firstName" value="<?= $firstName ?? '' ?>" required>
                   <label for="lastName">Last Name</label>
                   <input type="text" name="lastName" id="lastName" value="<?= $lastName ?? '' ?>" required>
                   <label for="roll">Roll</label>
                   <input type="number" name="roll" id="roll" value="<?= $roll ?? '' ?>" required>
                   <button type="submit" class="button-primary" name="submit">Save</button>
               </form>
           </div>
       </div>
	<?php endif; ?>

    <!--	edit student form output-->
	<?php if ("edit" === $taskHolder) :
		$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$studentEditable = getStudent(DATABASE_FILE, $id);
		if ($studentEditable):?>
          <div class="row">
              <div class="column column-60 column-offset-20">
                  <form action="/hasin haider/projects/CRUD/index.php?task=edit&id=<?= $id ?>" method="post">
                      <input type="hidden" name="id" value="<?= $id ?>">
                      <label for="firstName">First Name</label>
                      <input type="text" name="firstName" id="firstName"
                             value="<?= $studentEditable['firstName'] ?? '' ?>" required>
                      <label for="lastName">Last Name</label>
                      <input type="text" name="lastName" id="lastName"
                             value="<?= $studentEditable['lastName'] ?? '' ?>" required>
                      <label for="roll">Roll</label>
                      <input type="number" name="roll" id="roll"
                             value="<?= $studentEditable['roll'] ?? '' ?>" required>
                      <button type="submit" class="button-primary" name="submit">Update</button>
                  </form>
              </div>
          </div>
		<?php endif;
	endif; ?>

    <!--	delete student output-->
	<?php if ("delete" === $taskHolder) :
		$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$studentDeleted = deleteStudent(DATABASE_FILE, $id);
		if ($studentDeleted):?>
          <div class="row">
              <div class="column column-60 column-offset-20">
                  <p>Student Deleted Successfully</p>
                  <a href="/hasin haider/projects/CRUD/index.php?task=report">See Student Lists</a>
              </div>
          </div>
		<?php endif;
	endif; ?>

</div>
</body>
</html>