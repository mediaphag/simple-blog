<?php include __DIR__ . '/../header.php'; ?>
    <div style="text-align: center;">
        <h1>Log in</h1>
        <?php if (!empty($error)): ?>
            <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
        <?php endif; ?>
        <form action="/users/login" method="post">
            <label>Email <input type="email" name="email" value="<?= $_POST['email'] ?? '' ?>"></label>
            <br><br>
            <label>Password <input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>"></label>
            <br><br>
            <input type="submit" value="Log in">
        </form>
    </div>
    <div class="center">
        <a href="/users/password-recover" a>Forgot your password?</a>
    </div>
<?php include __DIR__ . '/../footer.php'; ?>
