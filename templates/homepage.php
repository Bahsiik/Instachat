<?php use Model\Emotion;

$css = ['homepage.css'];
$title = 'Instachat';

ob_start();
require_once('toolbar.php');
?>
<?php global $connected_user; ?>
<?php global $posts; ?>
<?php if (isset($connected_user)) { ?>
    <div class="homepage-container">
        <div class="title">
            <h1>Accueil</h1>
        </div>
        <div class="chat-container">
            <form class="post-form" action="/chat" method="post">
                <textarea class="chat-area" placeholder="Chatter quelque chose..." name="content"></textarea>
                <button type="button"><i class="fa-regular fa-image"></i></button>
                <div class="emotions">
                    <?php
                    for ($i = 1; $i < count(Emotion::cases()) + 1; $i++) {
                        ?>
                        <label>
                            <input type="radio" name="emotion" class="emotion"
                                   value="<?= $i ?>" <?= $i === 1 ? 'checked' : '' ?> required hidden/>
                            <span class="emoji-span"><?= Emotion::cases()[$i - 1]->display() ?></span>
                        </label>
                        <?php
                    }
                    ?>
                </div>
                <button type="submit">Chat</button>
            </form>
        </div>
        <div class="feed-container">
            <?php
            foreach ($posts as $post) {
                require('post.php');
            }
            ?>
        </div>
    </div>

<?php } ?>
<?php
$content = ob_get_clean();
require_once('layout.php');
