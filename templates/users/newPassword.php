<?php include __DIR__ . '/../header.php'; ?>
    <?php if (!empty($error)): ?>
        <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
    <?php endif; ?>
    <div style="text-align: center;">
        <h1>Entering a new password</h1>
        <div class="center">
            Enter a new password
        </div>

        <form action="/users/<?= $userId ?>/new-password/<?= $code ?>" method="post">
            <label>New password <input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>"></label>
            <br><br>
            <label>Enter new password second time<input type="password" name="secondPassword" value="<?= $_POST['secondPassword'] ?? '' ?>"></label>
            <br><br>
            <input type="submit" value="Save">
        </form>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>