<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Security\Services;

class CaptchaStorage
{
    public function retrieve(): string
    {
        return 'captcha';
    }
}
