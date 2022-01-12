<?php include __DIR__ . '/../header.php'; ?>
                <?php foreach ($articles as $article): ?>
                    <h2><a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h2>
                    <p><?= $article->getParsedText() ?></p>
                    <hr>
                <?php endforeach; ?>

<div style="text-align: center">
    <?php if ($previousPageLink !== null): ?>
        <a href="<?= $previousPageLink ?>">&lt; Previous</a>
    <?php else: ?>
        <span style="color: grey">&lt; Previous</span>
    <?php endif; ?>
    &nbsp;&nbsp;&nbsp;
    <?php for ($pageNum = 1; $pageNum <= $pagesCount; $pageNum++): ?>
        <?php if ($currentPageNum === $pageNum): ?>
            <b><?= $pageNum ?></b>
        <?php else: ?>
            <a href="/<?= $pageNum === 1 ? '' : $pageNum ?>"><?= $pageNum ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    &nbsp;&nbsp;&nbsp;
    <?php if ($nextPageLink !== null): ?>
        <a href="<?= $nextPageLink ?>">Next &gt;</a>
    <?php else: ?>
        <span style="color: grey">Next &gt;</span>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>