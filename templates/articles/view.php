<?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p>Автор статьи: <?= $article->getAuthor()->getNickname() ?></p>
    <p><?= $article->getText() ?></p>
<?php include __DIR__ . '/../footer.php'; ?>
