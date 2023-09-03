<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Security\Enums;

use Shockyrow\Sandbox\Common\Enum;

final class SecurityType extends Enum
{
    public const NONE = 'none';
    public const CONSENT = 'consent';
    public const CAPTCHA = 'captcha';
    public const PASSWORD = 'password';
}
