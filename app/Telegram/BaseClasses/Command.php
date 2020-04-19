<?php

namespace App\Telegram\BaseClasses;

use App\TelegramUser;
use Auth;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

abstract class Command extends \Telegram\Bot\Commands\Command
{
    protected TelegramUser $telegramUser;

    public function make(Api $telegram, $arguments, Update $update)
    {
        $this->telegramUser = Auth::guard('telegram_user')->user();
        return parent::make($telegram, $arguments, $update);
    }
}
