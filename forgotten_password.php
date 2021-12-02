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

<form name="forgotten_password_form" method="post" onsubmit="return validateForm()">

    <p><label for="username">username:</label></p>
    <p><input type="text" name="username" id="username"></p>

    <p><label for="email">email:</label></p>
    <p><input type="text" name="email" id="email"></p>

    <p><label for="new_password">new password:</label></p>
    <p><input type="text" name="new_password" id="new_password"></p>

    <p><label for="cnew_password">confirm new password:</label></p>
    <p><input type="text" name="cnew_password" id="cnew_password"></p>

    <p><input type="submit" name="change_password" value="change password"></p>
    <br>
    <p><a href="stranka3_logged_out.php">home</a></p>


    <script>
        function validateForm() {
            let username = document.forms["forgotten_password_form"]["username"].value;
            let email = document.forms["forgotten_password_form"]["email"].value;
            let new_password = document.forms["forgotten_password_form"]["new_password"].value;
            let cnew_password = document.forms["forgotten_password_form"]["cnew_password"].value;

            if (username === "" || email === "" || new_password === "" || cnew_password === "") {
                if (username === "") alert("Username must be filled out");
                if (new_password === "") alert("New password must be filled out");
                if (cnew_password === "") alert("Confirmed new password must be filled out");
                if (email === "") alert("Email must be filled out");
                return false;
            }

            if (username === new_password)
            {
                alert("Username can't be the same as password");
                return false;
            }

            let special_characters = [33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 58, 59,
                60,61, 62, 63, 64, 91, 92, 93, 94, 95, 96, 123, 124, 125, 126];
            let lowercase_characters = [97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111,
                112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122];
            let uppercase_characters = [65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79,
                80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90];
            let number_characters = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57];

            if (username.length >= 4)
            {
                for (let i = 0; i < username.length; i++) {
                    let ascii_letter = username.charCodeAt(i);
                    if (!(lowercase_characters.includes(ascii_letter) ||
                        uppercase_characters.includes(ascii_letter) ||
                        number_characters.includes(ascii_letter))
                    )
                    {
                        alert("Username can only contain lowercase, uppercase and number characters");
                        return false
                    }
                }
            }
            else
            {
                alert("Username must be at least 4 characters long");
                return false
            }

            if (new_password.length >= 6)
            {
                if (new_password !== cnew_password)
                {
                    alert("Confirmed new password must be the same as password");
                    return false;
                }

                let contains_special = false;
                let contains_capital = false;
                let contains_number = false;

                for (let i = 0; i < new_password.length; i++)
                {
                    let ascii_letter = new_password.charCodeAt(i);
                    if (special_characters.includes(ascii_letter)) contains_special = true;
                    if (uppercase_characters.includes(ascii_letter)) contains_capital = true;
                    if (number_characters.includes(ascii_letter)) contains_number = true;
                }

                if (!contains_special || !contains_capital || !contains_number)
                {
                    if (!contains_special) alert("New password must contain a special character");
                    if (!contains_capital) alert("New password must contain a capital character");
                    if (!contains_number) alert("New password must contain a number");
                    return false;
                }
            }
            else
            {
                alert("New password must be at least 6 characters long");
                return false
            }

            if (!String(email).toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/))
            {
                alert("Email is not valid");
                return false;
            }
        }
    </script>

</form>
</body>
</html>