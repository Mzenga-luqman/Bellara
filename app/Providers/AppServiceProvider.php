<?php

namespace App\Providers;

use App\Models\Booking;
use App\Observers\BookingObserver;
use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            $request = request();
            $forwardedProto = strtolower((string) $request->headers->get('x-forwarded-proto'));
            $isHttps = $request->isSecure() || $forwardedProto === 'https';
            $scheme = $isHttps ? 'https' : $request->getScheme();

            URL::forceRootUrl($scheme.'://'.$request->getHttpHost());

            if ($isHttps) {
                URL::forceScheme('https');
            }
        }

        $this->configureDefaults();
        $this->configureRateLimiting();
        Booking::observe(BookingObserver::class);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('booking-submit', fn (Request $request) => Limit::perMinute(10)->by($request->ip()));
        RateLimiter::for('availability-check', fn (Request $request) => Limit::perMinute(60)->by($request->ip()));
    }
}
