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

        <?php
        if(isset($_SESSION) && isset($_SESSION['id']) && $_SESSION['id'] === $user->id) {
            ?>
            <div class="flex">
                <a href='<?php echo URL_PATH . "users/$user->id/edit" ?>' class="icon link-text text">
                    edit account
                </a>

                <form
                    action="<?php echo URL_PATH . "posts/" . htmlspecialchars($user->id); ?>"
                    method="POST"
                >
                    <input type="hidden" name="_METHOD" value="DELETE"/>
                    <div class="flex flex-column form-group self-end">
                        <input type="submit" class="icon link-text text" value="X"/>
                    </div>
                </form>
            </div>
            <?php
        }
        ?>
    </div>
<?php endforeach; ?>

<a href='<?php echo URL_PATH . "users/register" ?>' class="icon link-text text">
    Dont have account? Click here to register.
</a>
</body>
</html>