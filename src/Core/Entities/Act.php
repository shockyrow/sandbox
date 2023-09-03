<?php

declare(strict_types=1);

namespace Shockyrow\Sandbox\Core\Entities;

use Closure;
use ReflectionException;
use ReflectionFunction;
use Shockyrow\Sandbox\Security\Entities\SecurityInterface;
use Shockyrow\Sandbox\Security\Entities\SimpleSecurity;
use Shockyrow\Sandbox\Security\Enums\SecurityType;

final class Act
{
    private string $name;
    private SecurityInterface $security;
    private ReflectionFunction $function;

    private function __construct(string $name, SecurityInterface $security, ReflectionFunction $function)
    {
        $this->name = $name;
        $this->security = $security;
        $this->function = $function;
    }

    /**
     * @throws ReflectionException
     */
    public static function create(string $name, $raw_act): self
    {
        if ($raw_act instanceof self) {
            return $raw_act;
        }

        $security = new SimpleSecurity(SecurityType::NONE);

        if ($raw_act instanceof Closure) {
            $security = new SimpleSecurity(SecurityType::CONSENT);
        } elseif (is_callable($raw_act)) {
            $security = new SimpleSecurity(SecurityType::CAPTCHA);
        } else {
            return self::createWithSecurity($name, $security, fn () => $raw_act);
        }

        return self::createWithSecurity($name, $security, $raw_act);
    }

    /**
     * @throws ReflectionException
     */
    public static function createWithSecurity(string $name, SecurityInterface $security, $raw_act): self
    {
        if ($raw_act instanceof self) {
            return $raw_act;
        }

        if ($raw_act instanceof Closure) {
            return new self($name, $security, new ReflectionFunction($raw_act));
        }

        if (is_callable($raw_act)) {
            $function = new ReflectionFunction($raw_act);

            return new self($function->getName(), $security, $function);
        }

        return self::createWithSecurity($name, $security, fn () => $raw_act);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSecurity(): SecurityInterface
    {
        return $this->security;
    }

    public function getFunction(): ReflectionFunction
    {
        return $this->function;
    }
}
