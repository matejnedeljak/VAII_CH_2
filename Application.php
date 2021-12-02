<?php

require "User.php";
require "DatabaseStorage.php";

class Application
{
    private $storage;

    public function __construct()
    {
        $this->storage = new DatabaseStorage();

        if (isset($_POST['register']))
        {
            $success = $this->storage->register(new User($_POST['username'], $_POST['password'], $_POST['email']));
            if ($success)
            {
                header("location: login.php");
            }
            else
            {
                echo "<script> alert('REGISTRATION FAILED, USER ALREADY EXISTS')</script>";
            }
        }
        if (isset($_POST['login']))
        {
            $user_id = $this->storage->getUserIDFromDatabaseByUsernamePassword($_POST['username'], $_POST['password']);
            if ($user_id != null)
            {
                session_start();
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $user_id;
                $_SESSION["username"] = $_POST["username"];
                header("location: stranka3_logged_in.php");
            }
            else
            {
                echo "<script> alert('WRONG USERNAME OR PASSWORD')</script>";
            }
        }
        if (isset($_POST['unregister']))
        {
            $found = $this->storage->getUserFromDatabaseByUsernamePassword($_POST['username'], $_POST['password']);
            if (isset($found))
            {
                $success = $this->storage->unregister($_POST['username'], $_POST['password']);
                if ($success)
                {
                    header("location: stranka3_logged_out.php");
                }
                else
                {
                    echo "<script> alert('UNREGISTRATION FAILED, WRONG USERNAME OR PASSWORD')</script>";
                }
            }
            else
            {
                echo "<script> alert('WRONG USERNAME OR PASSWORD')</script>";
            }

        }
        if (isset($_POST['change_password']))
        {
            $found = $this->storage->getUserFromDatabaseByUsernameEmail($_POST['username'], $_POST['email']);
            if (isset($found))
            {
                if ($found['password'] == $_POST['new_password'])
                {
                    echo "<script> alert('NEW PASSWORD CAN NOT BE THE SAME AS OLD PASSWORD')</script>";
                }
                else
                {
                    $this->storage->changePassword($_POST['username'], $_POST['email'], $_POST['new_password']);
                    header("location: login.php");
                }
            }
            else
            {
                echo "<script> alert('WRONG USERNAME OR EMAIL')</script>";
            }
        }
    }
}

