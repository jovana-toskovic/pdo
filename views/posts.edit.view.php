<!DOCTYPE html>
    <html>
        <head>
            <style>
                <?php require_once BASIC_PATH . "public/css/style.css"; ?>
            </style>
        </head>
        <body>
            <div class="flex center middle">
                <form action="http://pdo.test/posts/edit" method="PUT" class="post-form flex flex-column grow stretch blue">
                    <div class="flex" >
                        <label>Author: </label>
                        <input
                            class="flex grow"
                            value="<?php echo htmlspecialchars($params->author); ?>"
                            autofocus type="text" name="author" required />
                    </div>

                    <div class="flex grow">
                        <label>Title: </label>
                        <input
                            class="flex grow"
                            value="<?php echo htmlspecialchars($params->title); ?>"
                            autofocus type="text" name="author" required />
                    </div>

                    <div class="flex grow">
                        <label>Body: </label>
                        <input
                            class="flex grow"
                            value="<?php echo htmlspecialchars($params->body); ?>"
                            autofocus type="text" name="author" required />
                    </div>

                    <input type="hidden" name="id"
                           value="<?php echo htmlspecialchars($params->id); ?>"
                    />

                </form>
            </div>

        </body>
    </html>