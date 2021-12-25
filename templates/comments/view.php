<?php session_start();
foreach ($comments as $comment): ?>
    <div id="comment<?= $comment->getId() ?>">
        <h2>Comment by <?= $comment->getNickName() ?></h2>
        <p><?= $comment->getText() ?></p>
        <?php if (($user !== null) && ($comment->getUserId() === $user->getId() || $user->isAdmin())): ?>
            <a href="/comments/<?= $comment->getId() ?>/edit">Edit the comment</a>
            <br>
        <?php endif; ?>
    </div>
    <hr>
<?php endforeach; ?>
