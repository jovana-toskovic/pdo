<!DOCTYPE html>
    <html>
        <head>
            <style>
                <?php require_once __DIR__ . "/../public/css/style.css"; ?>
            </style>
        </head>
        <body>
            <?php foreach ($posts as $post) : ?>

                <div class="flex baseline">
                    <div></div>
                    <p><b><?php echo htmlspecialchars($post->author) . ": " ; ?></b></p>
                    <p><?php echo htmlspecialchars($post->body); ?></p>
                    <p><?php echo htmlspecialchars($post->id); ?></p>
                </div>

            <?php endforeach; ?>
        </body>
    </html>