<!DOCTYPE html>
    <html>
        <head>
            <style>
                <?php require BASIC_PATH . "public/css/style.css"; ?>
            </style>
        </head>
            <?php require BASIC_PATH . 'views/partials/nav.php'; ?>

            <?php foreach ($params as $post) : ?>
                <a href='<?php echo URL_PATH . "posts/$post->id"; ?>' class='icon link-text text'>
                    <div class="flex">
                        <p><b><?php echo htmlspecialchars($post->username) . ": " ; ?></b></p>
                        <p><?php echo htmlspecialchars($post->body); ?></p>

                        <?php
                        echo $post->id;
                            if(isset($_SESSION) && $_SESSION['id'] === $post->user_id) {

                                echo "
                                <div class='flex'>
                                    <a href=" . URL_PATH . "posts/$post->id/edit" . " class='icon link-text text'>
                                        edit
                                    </a>
            
                                    <a href=" . URL_PATH . "posts/$post->id" . "class='icon link-text text' >
                                        X
                                    </a>
                                </div>";
                            }
                        ?>
                    </div>
                </a>
            <?php endforeach; ?>

            <a href='<?php echo URL_PATH . "posts/create" ?>' class="icon link-text text">
                Create new post
            </a>
        </body>
    </html>