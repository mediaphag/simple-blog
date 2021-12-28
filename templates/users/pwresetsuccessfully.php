<?php include __DIR__ . '/../header.php'; ?>
<div style="text-align: center;">
    <?php if (!empty($error)): ?>
        <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
    <?php endif; ?>
    <h1>Пароль сброшен успешно</h1>
    <div class="center">
        Для установки новго пароля перейдите по ссылке из письма<br>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>
