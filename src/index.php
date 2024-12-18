<?php

use Alexv\Zad10p\User;

$user = new User();

$users = $user->fetchAll('SELECT * FROM username');
echo "Все пользователи:\n";
print_r($users);
echo "\n";

$userIdToUpdate = 2;
$updateData = [
    'name' => 'NeWW Name',
    'email' => 'NeWW@pppppp.com',
];

if ($user->updateUser($userIdToUpdate, $updateData)) {
    echo "Пользователь с ID {$userIdToUpdate} успешно обновлен.\n";
} else {
    echo "Не удалось обновить пользователя с ID {$userIdToUpdate}.\n";
}

echo "Обновленный пользователь:\n";
print_r($user->getUserById($userIdToUpdate));
echo "\n";

$nonExistentUserId = 1;
$updateData = [
    'name' => 'NEWW Name',
    'email' => 'NEW@gg.com',
];

if ($user->updateUser($nonExistentUserId, $updateData)) {
    echo "Пользователь с ID {$nonExistentUserId} успешно обновлен.\n";
} else {
    echo "Не удалось обновить пользователя с ID {$nonExistentUserId}, потому что пользователь не существует.\n";
}

echo "Попытка обновить несуществующего пользователя:\n";
print_r($user->getUserById($nonExistentUserId));
echo "\n";
