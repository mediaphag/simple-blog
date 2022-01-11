<?php

return [
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'],
    '~^users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'activate'],
    '~^users/password-recover$~' => [\MyProject\Controllers\UsersController::class, 'passwordRecover'],
    '~^users/(\d+)/new-password/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'newPassword'],
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
    '~^(\d+)$~' => [\MyProject\Controllers\MainController::class, 'page'],
    '~^articles/(\d+)/comments$~' => [\MyProject\Controllers\CommentsController::class, 'add'],
    '~^comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~^admin/dashboard$~' => [\MyProject\Controllers\AdminController::class, 'dashbord'],
    '~^admin/articles$~' => [\MyProject\Controllers\AdminController::class, 'viewArticles'],
    '~^admin/comments$~' => [\MyProject\Controllers\AdminController::class, 'viewComments']
];
