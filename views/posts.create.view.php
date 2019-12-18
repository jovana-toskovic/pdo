<!DOCTYPE html>
    <html>
    <head>
        <style>
            <?php require_once BASIC_PATH . "public/css/style.css"; ?>
        </style>
    </head>
    <body>
        <div class="flex column center middle  blue"">
            <form action="http://pdo.test/posts/edit" method="PUT">
                <div class="flex grow" >
                    <label>Author: </label>
                    <input
                        class="flex"
                        autofocus type="text" name="author" required />
                </div>

                <div class="flex grow">
                    <label>Title: </label>
                    <input
                        class="flex"
                        autofocus type="text" name="author" required />
                </div>

                <div class="flex grow">
                    <label>Body: </label>
                    <input
                        class="flex"
                        autofocus type="text" name="author" required />
                </div>

            </form>
        </div>

    </body>
    </html>