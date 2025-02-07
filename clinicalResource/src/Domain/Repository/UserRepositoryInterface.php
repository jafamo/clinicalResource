<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function totalItems(): int;
    public function userExist(string $email): ?User;
}
