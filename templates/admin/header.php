<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>
        <?= $pageTitle ?>
    </title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<table class="layout">

    <tr>
        <td colspan="2" class="header">
            <a href="/admin/dashboard"><?= $pageTitle ?></a>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="text-align: right">
            <?php if ($user !== null): ?>
                Привет, <?= $user->getNickname() ?> | <a href="/users/logout">Выйти</a>
            <?php endif ?>
        </td>
    </tr>

    <td width="300px" class="sidebar">
        <div class="sidebarHeader">Admin panel menu</div>
        <ul>
            <li><a href="/admin/articles">Articles list</a></li>
            <li><a href="/admin/comments">Comments list</a></li>
        </ul>
    </td>

    <td>