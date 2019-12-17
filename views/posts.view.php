<!DOCTYPE html>
    <html>
        <head>
            <style>
                <?php require_once BASIC_PATH . "public/css/style.css"; ?>
            </style>
        </head>
        <body>
            <?php foreach ($params as $post) : ?>

                <div class="flex baseline">
                    <div></div>
                    <p><b><?php echo htmlspecialchars($post->author) . ": " ; ?></b></p>
                    <p><?php echo htmlspecialchars($post->body); ?></p>
                    <p><?php echo htmlspecialchars($post->id); ?></p>
                </div>

            <?php endforeach; ?>
        </body>
    </html>