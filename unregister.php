<?php
    require "Application.php";
    session_start();
    $app = new Application();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="forms.css">
</head>
<body>

<div class="header"></div>

<form name="unregister_form" method="post" onsubmit="return validateForm()">

    <p><label for="username">username:</label></p>
    <p><input type="text" name="username" id="username"></p>

    <p><label for="password">password:</label></p>
    <p><input type="text" name="password" id="password"></p>

    <p><input type="submit" name="unregister" value="unregister"></p><br>
    <p><a href="stranka3_logged_out.php">home</a></p>


    <script>
        function validateForm() {
            let username = document.forms["registration_form"]["username"].value;
            let password = document.forms["registration_form"]["password"].value;

            if (username === "" || password === "") {
                if (username === "") alert("Username must be filled out");
                if (password === "") alert("Password must be filled out");
                return false;
            }
        }
    </script>

</form>
</body>
</html>