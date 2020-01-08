<div class="flex primary-background">
    <ul class="flex grow nav-text">
        <li class="primary-background nav-link">
            <a class="link-text white" href="<?php echo URL_PATH ?>home" >Home</a>
        </li>
        <li class="primary-background nav-link">
            <a class="link-text white" href="<?php echo URL_PATH ?>posts" >Posts</a>
        </li>
        <li class="primary-background nav-link">
            <a class="link-text white" href="<?php echo URL_PATH ?>users" >Users</a>
        </li>
        <?php
        if (isset($_SESSION) && isset($_SESSION['id'])) {
        ?>
            <form
                action="<?php echo URL_PATH . "logout"; ?>"
                method="POST"
            >
                <li class="primary-background nav-link flex flex-column self-end">
                    <input type="submit" class="link-text white btn-transparent" value="Logout"/>
                </li>
            </form>

        <?php
        }
        ?>
    </ul>
</div>
