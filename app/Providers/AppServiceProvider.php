<?php

namespace App\Providers;

use App\Models\DistributionItem;
use App\Models\DonationItem;
use App\Observers\DistributionItemObserver;
use App\Observers\DonationItemObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

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
        DistributionItem::observe(DistributionItemObserver::class);
        DonationItem::observe(DonationItemObserver::class);

        Relation::enforceMorphMap([
            'donation' => DonationItem::class,
            'distribution' => DistributionItem::class,
        ]);
    }
}
