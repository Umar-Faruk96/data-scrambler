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
        $serializedData = serialize($allStudents);
        file_put_contents($fileName, $serializedData);
    }

    function generateReport(string $fileName): void
    {
        $serializedData = file_get_contents($fileName);
        $allStudents = unserialize($serializedData);
        ?>
        <table>
            <thead>
            <tr>
                <th>Name</th>
                <th>Roll</th>
                <th>Action</th>
            </tr>
            </thead>
            <?php foreach ($allStudents

                           as $student): ?>
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
                            "<a href='/hasin haider/projects/CRUD/index.php?task=edit&id=%s'>Edit</a> | <a href='/hasin haider/projects/CRUD/index.php?task=delete&id=%s'>Delete</a>",
                            $student["id"], $student["id"]);
                        ?>
                    </td>
                </tr>
                </tbody>
            <?php endforeach; ?>

        </table>
        <?php
    }
