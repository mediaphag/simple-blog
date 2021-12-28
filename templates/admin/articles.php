<?php include __DIR__ . '/header.php'; ?>
<?php foreach ($articles as $article): ?>
    <h2><a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h2>
    <?php if (strlen($article->getText()) > 100): ?>
    <p><?= $article->getShortText() ?> ... </p>
    <?php else: ?>
    <p><?= $article->getText() ?></p>
    <?php endif; ?>
    <?php if (($user !== null) && $user->isAdmin()): ?>
        <a href="/articles/<?= $article->getId() ?>/edit">Edit the article</a>
        <br>
    <?php endif; ?>
    <hr>
<?php endforeach; ?>
<?php include __DIR__ . '/footer.php'; ?>
