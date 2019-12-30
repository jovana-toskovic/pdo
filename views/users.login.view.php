<!DOCTYPE html>
<html>
<head>
    <style>
        <?php require_once BASIC_PATH . "public/css/style.css"; ?>
    </style>
</head>
<body>
<?php require_once BASIC_PATH . '/views/partials/nav.php'; ?>
<div class="flex center middle">
    <form
        action="http://pdo.test/login/create"
        method="POST"
        class="post-form flex flex-column grow stretch"
    >
        <div class="flex flex-column form-group">
            <label class="input-label text">Email: </label>
            <input
                class="flex grow input-field text"
                autofocus type="email" name="email" required
            />
        </div>

        <div class="flex flex-column form-group">
            <label class="input-label text">Password: </label>
            <input
                class="flex grow input-field text"
                autofocus type="password" name="password" required
            />
        </div>

        <div class="flex flex-column form-group self-end">
            <input type="submit" class="btn-submit" value="Login"/>
        </div>
    </form>
</div>

</body>
</html>