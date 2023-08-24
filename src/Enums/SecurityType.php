<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Enums;

final class SecurityType extends Enum
{
    public const NONE = 'none';
    public const CONSENT = 'consent';
    public const CAPTCHA = 'captcha';
    public const PASSWORD = 'password';
}
