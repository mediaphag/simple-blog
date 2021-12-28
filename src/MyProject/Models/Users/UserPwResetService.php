<?php

namespace MyProject\Models\Users;

use MyProject\Services\Db;

class UserPwResetService
{
    private const TABLE_NAME = 'users_pwreset_codes';

    public static function createPwResetCode(User $user): string
    {
        $code = bin2hex(random_bytes(16));

        $db = Db::getInstance();
        $db->query(
            'INSERT INTO ' . self::TABLE_NAME . ' (user_id, code) VALUES (:user_id, :code)',
            [
                'user_id' => $user->getId(),
                'code' => $code
            ]
        );

        return $code;
    }

    public static function checkPwResetCode(User $user, string $code): bool
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM ' . self::TABLE_NAME . ' WHERE user_id = :user_id AND code = :code',
            [
                'user_id' => $user->getId(),
                'code' => $code
            ]
        );

        return !empty($result);
    }

    public static function deleteUsedCode(User $user): void
    {
        if ($user->getIsConfirmed()) {
            $db = Db::getInstance();
            $db->query('DELETE FROM `' . self::TABLE_NAME . '` WHERE user_id = :user_id',
                [
                    'user_id' => $user->getId()
                ]
            );
        }
    }
}