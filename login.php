<?php

include_once("config.php");
include_once("password_hash.php");

if(loggedIn()):
    header('Location: members.php');
    exit();
endif;

$hasher = new PasswordHash(8, FALSE);

if(isset($_POST["submit"])):
    $results = $coll->findOne(array('username' => $_POST['username']));

    if (isset($results['password']) && $results['password'] == $hasher->CheckPassword($_POST['password'], $results['password'])):
        cleanMemberSession($_POST["username"], $_POST["remember_me"]);
        header("Location: members.php");
        exit();
    else:
        $error = "Incorrect login/password, try again";
    endif;
endif;
?>
<html>
<head>
    <title>Simple Authentication with MongoDB</title>
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
    </table>
</form>
</body>
</html>