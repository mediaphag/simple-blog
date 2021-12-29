<?php include __DIR__ . '/../header.php'; ?>
<?php if ($error !== ''): ?>
<h1><?= $error ?></h1>
<?php else: ?>
<h1>Page not found</h1>
<?php endif; ?>
<?php include __DIR__ . '/../footer.php'; ?>

