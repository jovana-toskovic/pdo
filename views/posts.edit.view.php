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
                    action="http://pdo.test/posts/edit"
                    method="POST"
                    class="post-form flex flex-column grow stretch"
                >
                    <div class="flex flex-column form-group" >
                        <label class="text">Author: </label>
                        <input
                            class="flex grow input-field text"
                            value="<?php echo htmlspecialchars($params->author); ?>"
                            autofocus type="text" name="author" required
                        />
                    </div>

                    <div class="flex flex-column form-group">
                        <label class="input-label text">Title: </label>
                        <input
                            class="flex grow input-field text"
                            value="<?php echo htmlspecialchars($params->title); ?>"
                            autofocus type="text" name="title" required
                        />
                    </div>

                    <div class="flex flex-column form-group">
                        <label class="input-label text">Body: </label>
                        <input
                            class="flex grow input-field text"
                            value="<?php echo htmlspecialchars($params->body); ?>"
                            autofocus type="text" name="body" required
                        />
                    </div>

                    <input type="hidden" name="id"
                           value="<?php echo htmlspecialchars($params->id); ?>"
                    />

                    <input type="hidden" name="id"
                           value="<?php echo htmlspecialchars($params->user_id); ?>"
                    />
                    <input type="hidden" name="_METHOD" value="PUT"/>
                    <div class="flex flex-column form-group self-end">
                        <input type="submit" class="btn-submit" value="Edit"/>
                    </div>
                </form>
            </div>

        </body>
    </html>
