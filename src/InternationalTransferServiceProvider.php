<?php

namespace Kanexy\InternationalTransfer;

use Illuminate\Support\Facades\Gate;
use Kanexy\Cms\Traits\InteractsWithMigrations;
use Kanexy\InternationalTransfer\Contracts\TransferReasonConfiguration;
use Kanexy\InternationalTransfer\Contracts\TransferTypeFeeConfiguration;
use Kanexy\InternationalTransfer\Menu\InternationalTransferMenu;
use Kanexy\InternationalTransfer\Policies\TransferReasonPolicy;
use Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration;
use Kanexy\InternationalTransfer\Policies\MasterAccountPolicy;
use Kanexy\InternationalTransfer\Contracts\FeeConfiguration;
use Kanexy\InternationalTransfer\Policies\FeePolicy;
use Kanexy\InternationalTransfer\Policies\TransferTypeFeePolicy;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InternationalTransferServiceProvider extends PackageServiceProvider
{

    use InteractsWithMigrations;
    /**
     * The date and time for these migrations will be preserved when
     * published.
     *
     * @var array|string[]
     */

    protected array $migrationsWithPresetDateTime = [];

    private array $policies = [
        TransferTypeFeeConfiguration::class => TransferTypeFeePolicy::class,
        TransferReasonConfiguration::class => TransferReasonPolicy::class,
        MasterAccountConfiguration::class => MasterAccountPolicy::class,
        FeeConfiguration::class => FeePolicy::class
    ];

    public function registerDefaultPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }
    /**
     * A new date and time for these migrations will be appended in the
     * files when published.
     *
     * @var array|string[]
     */
    protected array $migrationsWithoutPresetDateTime = [];

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
         $package
            ->name('international-transfer')
            ->hasViews()
            ->hasRoute('web')
            ->hasRoute('api')
            ->hasTranslations()
            ->hasMigrations($this->migrationsWithoutPresetDateTime);

        $this->publishMigrationsWithPresetDateTime($this->migrationsWithPresetDateTime);
    }

    public function packageRegistered()
    {
    }

    public function packageBooted()
    {
        parent::packageBooted();

        $this->registerDefaultPolicies();

        \Kanexy\Cms\Facades\SidebarMenu::addItem(new InternationalTransferMenu());
    }
}
