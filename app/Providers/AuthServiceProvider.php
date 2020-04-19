<?php

namespace App\Providers;

use App\Telegram\Exceptions\NotImplementedTelegramMessage;
use App\TelegramUser;
use Auth;
use Telegram;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('telegram', function () {
            $update = Telegram::getWebhookUpdate();

            if ($update->isType('message'))
            {
                return TelegramUser::where('id', $update->getMessage()->getFrom()->getId())->first();
            }
            if ($update->isType('callback_query'))
            {
                return TelegramUser::where('id', $update->getCallbackQuery()->getFrom()->getId())->first();
            }

            throw new NotImplementedTelegramMessage('WebhookUpdate with unsupported message: ' . serialize($update));
        });
    }
}
