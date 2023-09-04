<?php
	declare(strict_types=1);
	const DATABASE_FILE = "C:\\Users\\User\\Documents\\codePractice\\php\\hasin haider\\projects\\CRUD\\data\\database.txt";
	//    ! store all students data in serialized way
	function seed(string $fileName): void
	{
		$allStudents = [
			[
				"id" => 1,
				"firstName" => "Amdad",
				"lastName" => "Munshi",
				"roll" => 11,
			], [
				"id" => 2,
				"firstName" => "Hafiz",
				"lastName" => "Munshi",
				"roll" => 8,
			], [
				"id" => 3,
				"firstName" => "Mahfuz",
				"lastName" => "Munshi",
				"roll" => 5,
			], [
				"id" => 4,
				"firstName" => "Mahdi",
				"lastName" => "Ahmed",
				"roll" => 3,
			], [
				"id" => 5,
				"firstName" => "Zubair",
				"lastName" => "Hasan",
				"roll" => 13,
			],
		];
		$serializedStudentsData = serialize($allStudents);
		file_put_contents($fileName, $serializedStudentsData, LOCK_EX);
	}
	
	function generateReport(string $fileName): void
	{
		$serializedStudentsData = file_get_contents($fileName);
		$allStudents = unserialize($serializedStudentsData);
		?>
       <table>
           <thead>
           <tr>
               <th>Name</th>
               <th>Roll</th>
               <th>Action</th>
           </tr>
           </thead>
			 <?php foreach ($allStudents as $student): ?>
              <tbody>
              <tr>
                  <td>
							<?php printf("%s %s", $student["firstName"], $student["lastName"]); ?>
                  </td>
                  <td>
							<?php printf("%s", $student["roll"]); ?>
                  </td>
                  <td>
							<?php printf(
								"<a href='/hasin haider/projects/CRUD/index.php?task=edit&id=%s'>Edit</a> | <a class='delete' href='/hasin haider/projects/CRUD/index.php?task=delete&id=%s'>Delete</a>",
								$student["id"],
								$student["id"]);
							?>
                  </td>
              </tr>
              </tbody>
			 <?php endforeach; ?>

       </table>
		<?php
	}
	
	function addStudent(string $fileName, string $firstName, string $lastName, $roll): bool
	{
		$serializedStudentsData = file_get_contents($fileName);
		$allStudents = unserialize($serializedStudentsData);
		$rollMatched = false;
		foreach ($allStudents as $_student) {
			if ($_student['roll'] == $roll) {
				$rollMatched = true;
				break;
			}
		}
		if (!$rollMatched) {
			$createStudentId = count($allStudents) + 1;
			$createStudent = [
				'id' => $createStudentId,
				'firstName' => $firstName,
				'lastName' => $lastName,
				'roll' => $roll,
			];
			$allStudents[] = $createStudent;
			
			$serializedStudentsData = serialize($allStudents);
			file_put_contents($fileName, $serializedStudentsData, LOCK_EX);
			return true;
		}
		return false;
	}
	
	function getStudent(string $fileName, string $id): mixed
	{
		$serializedStudentsData = file_get_contents($fileName);
		$allStudents = unserialize($serializedStudentsData);
		foreach ($allStudents as $student) {
			if ($student['id'] == $id) {
				return $student;
			}
		}
		return false;
	}
	
	function updateStudent(string $fileName, string $id, string $firstName, string $lastName, string $roll): bool
	{
		$serializedStudentsData = file_get_contents($fileName);
		$allStudents = unserialize($serializedStudentsData);
		$rollMatched = false;
		foreach ($allStudents as $_student) {
			if ($_student['roll'] == $roll && $_student['id'] != $id) {
				$rollMatched = true;
				break;
			}
		}
		if (!$rollMatched) {
			$allStudents[$id - 1]['firstName'] = $firstName;
			$allStudents[$id - 1]['lastName'] = $lastName;
			$allStudents[$id - 1]['roll'] = $roll;
			$serializeAgain = serialize($allStudents);
			file_put_contents($fileName, $serializeAgain, LOCK_EX);
			return true;
		}
		return false;
	}
	
	function deleteStudent(string $fileName, string $id): bool
	{
		$serializedStudentsData = file_get_contents($fileName);
		$allStudents = unserialize($serializedStudentsData);
		if ($id > 0) {
			unset($allStudents[$id - 1]);
		}
		$serializeAgain = serialize($allStudents);
		file_put_contents($fileName, $serializeAgain, LOCK_EX);
		return true;
	}
	
	/*function printRaw(string $fileName): void
	{
		$serializedStudentsData = file_get_contents($fileName);
		$allStudents = unserialize($serializedStudentsData);
		print_r($allStudents);
	}*/
