<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Security\Entities;

use Shockyrow\Sandbox\Security\Enums\SecurityType;

final class PasswordSecurity extends SimpleSecurity
{
    private string $password;

    public function __construct(string $password)
    {
        parent::__construct(SecurityType::PASSWORD);

        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
