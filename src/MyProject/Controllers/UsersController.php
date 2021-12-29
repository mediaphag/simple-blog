<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Models\Users\UserPwResetService;
use MyProject\Models\Users\UsersAuthService;
use MyProject\Services\EmailSender;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;

class UsersController extends AbstractController
{

    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUP($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }

            if ($user instanceof User) {
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Activation', 'userActivation.php',
                [
                    'userId' => $user->getId(),
                    'code' => $code
                ]
                );

                $this->view->renderHtml('users/signUpSuccessful.php');
                return;
            }
        }

        $this->view->renderHtml('users/signUp.php');
    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::getById($userId);
        if ($user === null) {
            throw new NotFoundException('User not found');
        }
        if ($user->getIsConfirmed()) {
            $this->view->renderHtml('users/activationSuccessful.php',
            [
                'isAlreadyActivated' => true
            ]);
            return;
        }
        $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
        if ($isCodeValid) {
            $user->activate();
            UserActivationService::deleteUsedCode($user);
            $this->view->renderHtml('users/activationSuccessful.php',
                [
                    'isAlreadyActivated' => false
                ]);
            return;
        }
        throw new NotFoundException('Activation code is not valid');
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
        UsersAuthService::deleteToken();
        $this->view->renderHtml('users/logout.php', ['user' => null]);
    }

    public function passwordRecover(): void
    {
        if (!empty($_POST)) {
            try {
                $user = User::findOneByColumn('email', $_POST['email']);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/passwordRecover.php', ['error' => $e->getMessage()]);
                return;
            }

            if ($user === null) {
                throw new NotFoundException('User with this email not found');
                return;
            }

            if ($user instanceof User) {
                $code = UserPwResetService::createPwResetCode($user);

                EmailSender::send($user, 'Password reset', 'userPwReset.php',
                    [
                        'userId' => $user->getId(),
                        'code' => $code
                    ]
                );
            }

            $this->view->renderHtml('users/pwResetSuccessfully.php');
            return;

        }

        $this->view->renderHtml('users/passwordRecover.php');
    }

    public function newPassword(int $userId, string $pwResetCode)
    {
        $user = User::getById($userId);
        if ($user === null) {
            throw new NotFoundException('User not found');
        }

        $isCodeValid = UserPwResetService::checkPwResetCode($user, $pwResetCode);
        if ($isCodeValid) {
            if (!empty($_POST)) {
                try {
                    $user->setNewPassword($_POST, $userId);
                    UserPwResetService::deleteUsedCode($user);
                    $this->view->renderHtml('users/newPasswordSuccessful.php');
                } catch (InvalidArgumentException $e) {
                    $this->view->renderHtml('errors/404.php', ['error' => $e->getMessage()]);
                }
                return;
            }

            $this->view->renderHtml('users/newPassword.php', ['userId' => $userId, 'code' => $pwResetCode]);
            return;
        }

        throw new NotFoundException('Reset code is not valid');
    }
}