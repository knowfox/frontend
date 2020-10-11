<?php

namespace Knowfox\Frontend;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Barryvdh\Cors\HandleCors;
use Illuminate\Routing\Middleware\SubstituteBindings;

use Knowfox\Core\Models\Concept;
use Knowfox\Core\Policies\ConceptPolicy;

use Knowfox\Frontend\ViewComposers\AlphaIndexComposer;
use Knowfox\Frontend\ViewComposers\ImpactMapComposer;

use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

class ServiceProvider extends IlluminateServiceProvider
{
    protected $namespace = '\Knowfox\Frontend\Controllers';

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../frontend.php', 'frontend'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('concept.show-impact-map', ImpactMapComposer::class);
        View::composer('partials.alpha-nav', AlphaIndexComposer::class);

        //Route::model('concept', Concept::class);

        Route::prefix('frontend')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/web.php');

        $this->loadViewsFrom(__DIR__ . '/../views', 'frontend');

        $this->publishes([
            __DIR__ . '/../frontend.php' => config_path('frontend.php'),
        ]);
    }
}
