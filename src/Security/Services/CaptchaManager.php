<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Security\Services;

class CaptchaManager
{
    private const LENGTH = 10;
    private const CHARACTERS = 'abcdefghijklmnopqrstuvwxyz1234567890';

    private string $captcha;

    public function __construct(?string $captcha = null)
    {
        if ($captcha !== null) {
            $this->captcha = $captcha;
        } else {
            $this->refresh();
        }
    }

    public function getCaptcha(): string
    {
        return $this->captcha;
    }

    /**
     * @return $this
     */
    public function refresh(): self
    {
        $total_characters = strlen(self::CHARACTERS);
        $this->captcha = '';

        for ($ignored = 0; $ignored < self::LENGTH; $ignored++) {
            $index = rand() % $total_characters;
            $this->captcha .= self::CHARACTERS[$index];
        }

        return $this;
    }
}
