<?php
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'validate.inc';
    validateName($errors, $_POST, 'surname');
    validateEmail($errors, $_POST, 'email');
    validatePassword($errors, $_POST, 'password');
    validateAge($errors, $_POST, 'age');
    validateDateOfBirth($errors, $_POST, 'dob');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form (Complete Validation)</title>
    <link rel="stylesheet" href="../Soal 1/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .success {
            color: green;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($errors) {
                echo '<div class="error">';
                echo '<h3>Please correct the following errors:</h3>';
                foreach ($errors as $field => $error) {
                    echo ucfirst($field) . " is $error<br>";
                }
                echo '</div>';
            } else {
                echo '<div class="success">';
                echo '<h3>All data is valid. Form submitted successfully!</h3>';
                echo '</div>';
            }
        }

        include 'form.inc';
        ?>
    </div>
</body>
</html>
