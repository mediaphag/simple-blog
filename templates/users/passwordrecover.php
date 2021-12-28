<?php include __DIR__ . '/../header.php'; ?>
<div style="text-align: center;">
    <h1>Сброс текущего пароля</h1>
    <div class="center">
        Для сброса и восстановления пароля введи email с которым вы были зарегистрированы.<br>
        На указанную почту придет ссылка, ведущая на форму ввода нового пароля.
    </div>
    <?php if (!empty($error)): ?>
        <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
    <?php endif; ?>
    <form action="/users/passwordrecover" method="post">
        <label>Email <input type="email" name="email" value="<?= $_POST['email'] ?? '' ?>"></label>
        <br><br>
        <input type="submit" value="Сбросить пароль">
    </form>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
