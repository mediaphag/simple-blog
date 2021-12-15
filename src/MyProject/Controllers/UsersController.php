<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Exceptions\NotFoundException;
use MyProject\Services\EmailSender;
use MyProject\View\View;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;

class UsersController
{
    /** @var View */
    private $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../../../templates');
    }

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

                EmailSender::send($user, 'Активация', 'userActivation.php',
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
            $this->view->renderHtml('users/activationsuccessful.php',
            [
                'isAlreadyActivated' => true
            ]);
            return;
        }
        $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
        if ($isCodeValid) {
            $user->activate();
            UserActivationService::deleteUsedCode($user);
            $this->view->renderHtml('users/activationsuccessful.php',
                [
                    'isAlreadyActivated' => false
                ]);
            return;
        }
        throw new NotFoundException('Activation code is not valid');
    }
}