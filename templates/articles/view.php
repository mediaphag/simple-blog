<?php include __DIR__ . '/../header.php'; ?>
    <?php if (!empty($error)): ?>
        <div style="color: red;"><?= $error ?></div>
    <?php endif; ?>
    <h1><?= $article->getName() ?></h1>
    <p>Автор статьи: <?= $article->getAuthor()->getNickname() ?></p>
    <p><?= $article->getText() ?></p>
    <br>
    <?php if ($user !== null && $user->isAdmin()): ?>
    <a href="/articles/<?= $article->getId() ?>/edit">Edit the article</a>
    <br>
    <?php endif ?>
    <h2>Comments</h2><br>
<?php include __DIR__ . '/../comments/view.php'; ?>
    <br>
    <?php if ($user !== null): ?>
        <form action="/articles/<?= $article->getId() ?>/comments" method="post">
            <label for="text">Comment text</label><br>
            <textarea name="text" id="text" rows="10" cols="80"><?= $_POST['text'] ?? ''?></textarea><br>
            <br>
            <input type="submit" value="Add">
        </form>
    <?php else: ?>
        <a href="/users/login">Sign in</a> | or <a href="/users/register">Sign up</a> for leave a comment
    <?php endif ?>

<?php include __DIR__ . '/../footer.php'; ?>
