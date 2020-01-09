<!DOCTYPE html>
<html>
<head>
    <style>
        <?php require_once BASIC_PATH . "public/css/style.css"; ?>
    </style>
</head>
<body>
<?php require_once BASIC_PATH . 'views/partials/nav.php'; ?>

<div class="flex center middle">
    <form
        action="<?php echo URL_PATH . 'users/' . htmlspecialchars($params->id); ?>"
        method="POST"
        class="post-form flex flex-column grow stretch"
    >
        <div class="flex flex-column form-group" >
            <label class="text">Username: </label>
            <input
                class="flex grow input-field text"
                value="<?php echo htmlspecialchars($params->username); ?>"
                autofocus type="text" name="username" required
            />
        </div>

        <div class="flex flex-column form-group">
            <label class="input-label text">Password: </label>
            <input
                class="flex grow input-field text"
                autofocus type="password" name="password" required
            />
        </div>

        <div class="flex flex-column form-group">
            <label class="input-label text">Email: </label>
            <input
                class="flex grow input-field text"
                value="<?php echo htmlspecialchars($params->email); ?>"
                autofocus type="email" name="email" required
            />
        </div>

        <input type="hidden" name="id"
               value="<?php echo htmlspecialchars($params->id); ?>"
        />
        <input type="hidden" name="_METHOD" value="PUT"/>
        <div class="flex flex-column form-group self-end">
            <input type="submit" class="btn-submit" value="Edit"/>
        </div>
    </form>
</div>

</body>
</html>