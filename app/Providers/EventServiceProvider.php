<?php

namespace App\Providers;

use App\Events\ParticipantLoggedIn;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\WithdrawalPlacedNotifyAdmin;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\ReferralCompleted;
use App\Listeners\ForgetReferralCookie;
use App\Listeners\ForgetParticipantCookie;
use App\Listeners\ForgetGiveawayLoginCookie;
use App\Events\ParticipantRegistered;
use App\Events\ReferralDetected;
use App\Events\WithdrawalPlaced;
use App\Events\WithdrawalCancelled;
use App\Events\WithdrawalApproved;
use App\Events\WithdrawalAutomaticallyPaid;
use App\Listeners\RegisterNewReferralConnection;
use App\Listeners\AddWithdrawalToSpreadsheet;
use App\Listeners\NotifyUserWithdrawalCancelled;
use App\Listeners\NotifyUserWithdrawalApproved;
use App\Listeners\WithdrawalPaidNotifyAdmin;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // ... other providers
            \SocialiteProviders\Telegram\TelegramExtendSocialite::class . '@handle',
            \SocialiteProviders\Yandex\YandexExtendSocialite::class . '@handle',
            \SocialiteProviders\VKontakte\VKontakteExtendSocialite::class . '@handle',
            \SocialiteProviders\TikTok\TikTokExtendSocialite::class . '@handle',
            \SocialiteProviders\Google\GoogleExtendSocialite::class . '@handle',
        ],
        ReferralCompleted::class => [
            ForgetReferralCookie::class,
        ],
        ReferralDetected::class => [
            RegisterNewReferralConnection::class,
        ],
        WithdrawalPlaced::class => [
            AddWithdrawalToSpreadsheet::class,
            WithdrawalPlacedNotifyAdmin::class,
        ],
        WithdrawalAutomaticallyPaid::class => [
            WithdrawalPaidNotifyAdmin::class,
        ],
        WithdrawalCancelled::class => [
            NotifyUserWithdrawalCancelled::class,
        ],
        // WithdrawalApproved::class => [
        //     NotifyUserWithdrawalApproved::class,
        // ],
        ParticipantRegistered::class => [
            ForgetParticipantCookie::class,
        ],
        ParticipantLoggedIn::class => [
            ForgetGiveawayLoginCookie::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
