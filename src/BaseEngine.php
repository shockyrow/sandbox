<?php

namespace Shockyrow\Sandbox;

use Shockyrow\Sandbox\Entities\ActList;
use Shockyrow\Sandbox\Entities\CallList;
use Shockyrow\Sandbox\Entities\CallRequest;
use Shockyrow\Sandbox\Template\TemplateEngine;

abstract class BaseEngine implements EngineInterface
{
    private TemplateEngine $template_engine;

    public function __construct(TemplateEngine $template_engine)
    {
        $this->template_engine = $template_engine;
    }

    public function getTemplateEngine(): TemplateEngine
    {
        return $this->template_engine;
    }
}
