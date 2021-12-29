<?php include __DIR__ . '/../header.php'; ?>
<div style="text-align: center;">
    <?php if (!empty($error)): ?>
        <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
    <?php endif; ?>
    <h1>Password reset successfully</h1>
    <div class="center">
        To set a new password, follow the link from the letter<br>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>
