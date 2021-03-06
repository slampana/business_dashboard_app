<?php

include_once("modules/config.php");
include_once("modules/class.user.php");

if(loggedIn()):
    header('Location: dashboard.php');
    exit();
endif;

$hasher = new PasswordHash(8, FALSE);

if(isset($_POST["submit"])):
    $query = $coll->findOne(array('username' => $_POST['username']));

    if (isset($query['password']) && $query['password'] == $hasher->CheckPassword($_POST['password'], $query['password'])):
        cleanMemberSession($_POST["username"], $_POST["remember_me"]);
        echo '<script> window.location="dashboard.php"; </script> ';
    else:
        $error = "Incorrect login/password, try again";
    endif;
endif;

if(isset($_POST["forgot_password"])):
    header('Location: old_password-reset.php');
    exit();
endif;

if(isset($_POST["register"])):
    header('Location: register.php');
    exit();
endif;

?>

<html>
<head>
    <title>Simple Login with MongoDB</title>
</head>
<body>
<?php if (isset($error)): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>
<form action="<?=$_SERVER["PHP_SELF"];?>" method="POST">
    <table>
        <tr>
            <td>
                Username:
            </td>
            <td>
                <input type="text" name="username" value="<?php print isset($_POST["username"]) ? $_POST["username"] : "" ; ?>" maxlength="30">
            </td>
        </tr>
        <tr>
            <td>
                Password:
            </td>
            <td>
                <input type="password" name="password" value="" maxlength="30">
            </td>
        </tr>
        <tr>
            <td>
                Remember Me:
            </td>
            <td>
                <input type="checkbox" name="remember_me">
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                <input name="submit" type="submit" value="Submit">
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                <input name="forgot_password" type="submit" value="Forgot Password">
            </td>
        </tr>
        <tr>
            <td>
                &nbsp;
            </td>
            <td>
                <input name="register" type="submit" value="Register">
            </td>
        </tr>
    </table>
</form>
</body>
</html>