<?php include __DIR__ . '/../header.php'; ?>
<div style="text-align: center;">
    <h1>Resetting the current password</h1>
    <div class="center">
        To reset and set a new password, enter the email with which you were registered.<br>
        A link will be sent to the specified mail, leading to the form for entering a new password.
    </div>
    <?php if (!empty($error)): ?>
        <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
    <?php endif; ?>
    <form action="/users/password-recover" method="post">
        <label>Email <input type="email" name="email" value="<?= $_POST['email'] ?? '' ?>"></label>
        <br><br>
        <input type="submit" value="Reset password">
    </form>
</div>
<?php include __DIR__ . '/../footer.php'; ?>
