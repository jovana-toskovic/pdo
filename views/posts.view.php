<!DOCTYPE html>
    <html>
        <head>
            <style>
                <?php require BASIC_PATH . "public/css/style.css"; ?>
            </style>
        </head>
        <body>
            <?php require BASIC_PATH . 'views/partials/nav.php'; ?>

            <?php foreach ($params as $post) : ?>

                <a href='<?php echo URL_PATH . "posts/edit/$post->id" ?>' class="flex baseline link-text text">
                    <p><b><?php echo htmlspecialchars($post->author) . ": " ; ?></b></p>
                    <p><?php echo htmlspecialchars($post->body); ?></p>
                </a>

            <?php endforeach; ?>
        </body>
    </html>