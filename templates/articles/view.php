<?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p>Автор статьи: <?= $article->getAuthor()->getNickname() ?></p>
    <p><?= $article->getText() ?></p>
    <br>
    <?php if ($user !== null && $user->isAdmin()): ?>
    <a href="/articles/<?= $article->getId() ?>/edit">Edit the article</a>
    <br>
    <?php endif ?>

<?php include __DIR__ . '/../footer.php'; ?>
