<?php foreach ($comments as $comment): ?>
    <div id="comment<?= $comment->getId() ?>">
        <h2>Comment by <?= $comment->getNickName() ?></h2>
        <p><?= $comment->getText() ?></p>
    </div>
    <hr>
<?php endforeach; ?>
