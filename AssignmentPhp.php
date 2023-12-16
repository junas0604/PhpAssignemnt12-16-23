<?php
// Example student data
$students = array(
    array('id' => 1, 'name' => 'John', 'grade' => 80),
);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<style>
    .nav {
        color: blue;
        font-family: Arial;
        font-size: 16px;
        item-align: center;
        text-align: center;
        border-style: solid;
        border-radius: 25px;
        border: 2px solid black;
        margin-top: 20px;
    }

    .nav-brand {
        color: gray;
    }

    .add-button,
    .update-button,
    .list-button,
    .delete-button {
        color: black;
        font-family: Arial;
        font-size: 16px;
        margin-top: 20px;
        height: 50px;
        width: 150px;
        border-radius: 5px;
    }

    .delete-button {
        color: red;
        border: 2px solid red;
    }

    .table-margin {
        margin-top: 30px;
        display: none;
    }

    .add-form {
        display: none;
        margin-top: 20px;
        margin-left: 30px;
    }
</style>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteStudents"])) {
        // Check if any students are selected for deletion
        if (isset($_POST["selectedStudents"]) && is_array($_POST["selectedStudents"])) {
            // Get the selected student IDs
            $selectedIds = $_POST["selectedStudents"];

            // Remove the selected students from the data
            $students = array_filter($students, function ($student) use ($selectedIds) {
                return !in_array($student['id'], $selectedIds);
            });
        }
    }
    ?>

    <nav class="nav">
        <div class="container-fluid">
            <h1 class="nav-brand">STUDENTS</h1>
        </div>
    </nav>
    <div>
        <button class="add-button" onclick="toggleForm()">Add Student</button>
        <button class="list-button" onclick="toggleTable()">List of Student</button>
        <button class="delete-button" onclick="deleteStudent()">Delete Student</button>
        <button class="update-button" onclick="">Update Student Information</button>
    </div>
    <div class="add-form">
        <form>
            <label for="id">ID:</label>
            <input type="text" id="id" name="id"><br>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name"><br>

            <label for="grade">Grade:</label>
            <input type="text" id="grade" name="grade"><br>

            <button type="button" onclick="addStudent()">Submit</button>
        </form>
    </div>
    <form method="post" action="">
        <div class="table-margin" id="studentTableDiv">
            <table class="table table-striped table" id="studentTable">
                <thead>
                    <tr>
                        <th scope="col">Select</th>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><input type="checkbox" name="selectedStudents[]" value="<?= $student['id'] ?>"></td>
                            <td><?= $student['id'] ?></td>
                            <td><?= $student['name'] ?></td>
                            <td><?= $student['grade'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" name="deleteStudents">Delete Selected Students</button>
        </div>
    </form>

    <script>
        function toggleForm() {
            var addForm = document.querySelector('.add-form');
            addForm.style.display = (addForm.style.display === 'none' || addForm.style.display === '') ? 'block' : 'none';
        }

        function toggleTable() {
            var tableDiv = document.getElementById('studentTableDiv');
            tableDiv.style.display = (tableDiv.style.display === 'none' || tableDiv.style.display === '') ? 'block' : 'none';
        }

        function addStudent() {
            // Retrieve form values
            var id = document.getElementById('id').value;
            var name = document.getElementById('name').value;
            var grade = document.getElementById('grade').value;

            // Create a new row and append it to the table
            var table = document.getElementById('studentTable');
            var newRow = table.insertRow(table.rows.length);
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            var cell3 = newRow.insertCell(2);

            cell1.innerHTML = '<input type="checkbox" name="selectedStudents[]" value="' + id + '">';
            cell2.innerHTML = id;
            cell3.innerHTML = name;
            // Additional cells for other data

            // Reset the form fields
            document.getElementById('id').value = '';
            document.getElementById('name').value = '';
            document.getElementById('grade').value = '';

            // Hide the form after adding the student
            toggleForm();
        }

        function deleteStudent() {
            var confirmation = confirm("Are you sure you want to delete the selected students?");
            if (confirmation) {
                // You can submit the form for server-side processing if needed
                document.querySelector('form').submit();
            }
        }
    </script>

</body>

</html>
