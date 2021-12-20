<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>
        <?= $pageTitle ?? 'Мой блог !!!' ?>

    </title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">
            <?= $pageTitle ?? 'Мой блог !!!' ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <?php if (!empty($user)): ?>
                Привет, <?= $user->getNickname() ?> | <a href="/users/logout">Выйти</a>
            <?php else: ?>
            <a href="/users/login">Войти</a> | <a href="/users/register">Зарегистрироаться</a>
            <?php endif ?>
<!--    <?//= !empty($user) ? 'Привет, ' . $user->getNickname() : 'Войдите на сайт' ?>    -->
        </td>
    </tr>
    <tr>
        <td>
