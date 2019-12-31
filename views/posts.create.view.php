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
                action="http://pdo.test/posts"
                method="POST"
                class="post-form flex flex-column grow stretch"
            >
                <div class="flex flex-column form-group" >
                    <p class="text">Author: <?php echo $params->username; ?></php>
                </div>

                <div class="flex flex-column form-group">
                    <label class="input-label text">Title: </label>
                    <input
                        class="flex grow input-field text"
                        autofocus type="text" name="title" required
                    />
                </div>

                <div class="flex flex-column form-group">
                    <label class="input-label text">Body: </label>
                    <input
                        class="flex grow input-field text"
                        autofocus type="text" name="body" required
                    />
                </div>

                <input type="hidden" name="user_id"
                       value="<?php echo htmlspecialchars($_SESSION['id']); ?>"
                />

                <div class="flex flex-column form-group self-end">
                    <input type="submit" class="btn-submit" value="Create"/>
                </div>
            </form>
        </div>

    </body>
    </html>