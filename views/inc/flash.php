<?php

$flashMessages = flashMessages();

?>
<?php if (!empty($flashMessages)): ?>
    <?php foreach($flashMessages as $key => $message): ?>
        <div class="alert alert-<?= $key ?>" role="alert">
            <?= $message ?>
        </div>
    <?php endforeach ?>
<?php endif ?>
