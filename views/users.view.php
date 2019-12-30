<!DOCTYPE html>
<html>
<head>
    <style>
        <?php require BASIC_PATH . "public/css/style.css"; ?>
    </style>
</head>
<?php require BASIC_PATH . 'views/partials/nav.php'; ?>

<?php foreach ($params as $user) : ?>
    <div class="flex">
        <div class="flex flex-column">
            <p><b>Username:</b> <?php echo htmlspecialchars($user->username); ?></p>
            <p><b>E-mail:</b> <?php echo htmlspecialchars($user->email); ?></p>
        </div>
        <div class="flex">
            <a href='<?php echo URL_PATH . "users/edit/$user->id" ?>' class="icon link-text text">
                edit account
            </a>

            <a href='<?php echo URL_PATH . "users/delete/$user->id" ?>' class="icon link-text text" >
                delete account
            </a>
        </div>
    </div>
<?php endforeach; ?>

<a href='<?php echo URL_PATH . "users/register" ?>' class="icon link-text text">
    Dont have account? Click here to register.
</a>
</body>
</html>