<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>
        <?= $pageTitle ?? 'Corporate blog' ?>

    </title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            <?= $pageTitle ?? 'Corporate blog' ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?php if ($user !== null): ?>
                Hello, <?= $user->getNickname() ?> |
                    <?php if ($user->isAdmin()): ?>
                        <a href="/admin/dashboard">Enter to admin panel</a> |
                    <?php endif ?>
                <a href="/users/logout">Log out</a>
            <?php else: ?>
            <a href="/users/login">Log in</a> | <a href="/users/register">Register now</a>
            <?php endif ?>
        </td>
    </tr>
    <tr>
        <td>
