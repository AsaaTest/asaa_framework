<?php

namespace App\Providers;

use Asaa\Providers\ServiceProvider;
use Asaa\Validation\Rule;

class RuleServiceProvider implements ServiceProvider
{
    public function registerServices()
    {
        Rule::loadDefaultRules();
        // Rule::load();
    }
}
