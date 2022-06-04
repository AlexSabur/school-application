<?php

namespace App\Attributes\View;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Composer
{
    public readonly array $views;

    /**
     *
     * @param string|array $views
     * @return void
     */
    public function __construct($views = '*')
    {
        $views = is_string($views) ? func_get_args() : $views;

        $this->views = filled($views) ? $views : ['*'];
    }
}
