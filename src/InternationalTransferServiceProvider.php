<?php

namespace Kanexy\InternationalTransfer;

use Illuminate\Support\Facades\Gate;
use Kanexy\Cms\Traits\InteractsWithMigrations;
use Kanexy\InternationalTransfer\Contracts\FeeConfiguration;
use Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration;
use Kanexy\InternationalTransfer\Contracts\MoneyTransfer;
use Kanexy\InternationalTransfer\Contracts\TransferReasonConfiguration;
use Kanexy\InternationalTransfer\Contracts\TransferTypeFeeConfiguration;
use Kanexy\InternationalTransfer\Livewire\ExistingBeneficiary;
use Kanexy\InternationalTransfer\Livewire\InitialProcess;
use Kanexy\InternationalTransfer\Livewire\MyselfBeneficiary;
use Kanexy\InternationalTransfer\Livewire\OtpVerification;
use Kanexy\InternationalTransfer\Livewire\TransactionDetailComponent;
use Kanexy\InternationalTransfer\Livewire\TransactionLogComponent;
use Kanexy\InternationalTransfer\Livewire\TransactionTrackComponent;
use Kanexy\InternationalTransfer\Menu\InternationalTransferMenu;
use Kanexy\InternationalTransfer\Policies\FeePolicy;
use Kanexy\InternationalTransfer\Policies\MasterAccountPolicy;
use Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy;
use Kanexy\InternationalTransfer\Policies\TransferReasonPolicy;
use Kanexy\InternationalTransfer\Policies\TransferTypeFeePolicy;
use Livewire\Livewire;
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
        FeeConfiguration::class => FeePolicy::class,
        MoneyTransfer::class => MoneyTransferPolicy::class,
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
        Livewire::component('initial-process', InitialProcess::class);
        Livewire::component('myself-beneficiary', MyselfBeneficiary::class);
        Livewire::component('otp-verification', OtpVerification::class);
        Livewire::component('existing-beneficiary', ExistingBeneficiary::class);
        Livewire::component('transaction-detail-component', TransactionDetailComponent::class);
        Livewire::component('transaction-log-component',TransactionLogComponent::class);
        Livewire::component('transaction-track-component',TransactionTrackComponent::class);

    }
}
