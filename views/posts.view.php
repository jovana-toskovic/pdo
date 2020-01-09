<!DOCTYPE html>
    <html>
        <head>
            <style>
                <?php require BASIC_PATH . "public/css/style.css"; ?>
            </style>
        </head>
            <?php require BASIC_PATH . 'views/partials/nav.php'; ?>

            <?php foreach ($params as $post) : ?>
                <div class="flex">
                    <p><b><?php echo htmlspecialchars($post->username) . ": " ; ?></b></p>
                    <p><?php echo htmlspecialchars($post->body); ?></p>

                    <?php
                        if(isset($_SESSION) && isset($_SESSION['id']) && $_SESSION['id'] === $post->user_id) {
                    ?>
                        <div class="flex">
                            <a href='<?php echo URL_PATH . "posts/$post->id/edit" ?>' class="icon link-text text">
                                edit
                            </a>

                            <form
                                action="<?php echo URL_PATH . "posts/" . htmlspecialchars($post->id); ?>"
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

            <a href='<?php echo URL_PATH . "posts/create" ?>' class="icon link-text text">
                Create new post
            </a>
        </body>
    </html>