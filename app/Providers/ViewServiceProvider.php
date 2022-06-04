<?php

namespace App\Providers;

use App\Attributes\View\Composer;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $paths = [
            app_path('View/Composers'),
        ];

        $namespace = $this->app->getNamespace();

        foreach ((new Finder)->in($paths)->files() as $command) {
            $class = $namespace.str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($command->getRealPath(), realpath(app_path()).DIRECTORY_SEPARATOR)
            );

            $reflectionClass = new ReflectionClass($class);

            $composerClassInstance = $this->app->make($class);

            foreach ($reflectionClass->getMethods() as $method) {
                $attributes = $method->getAttributes(Composer::class);

                $views = [];

                foreach ($attributes as $attribute) {
                    /** @var Composer */
                    $composer = $attribute->newInstance();

                    $views[] = $composer->views;
                }

                $views = array_unique(Arr::flatten($views));

                $this->app->get(ViewFactory::class)->composer(
                    $views,
                    fn (...$attributes) => $composerClassInstance->{$method->getName()}(...$attributes)
                );
            }
        }
    }
}
