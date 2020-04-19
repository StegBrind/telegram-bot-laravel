<?php

namespace App\Telegram\Commands;

use App\Telegram\Interfaces\ExtraCommandInfo;
use App\TelegramUser;
use App\Telegram\BaseClasses\Command;

class StartCommand extends Command implements ExtraCommandInfo
{
    public $name = 'start';

    public function isHidden(): bool
    {
        return true;
    }

    public function isPhrase(): bool
    {
        return false;
    }

    public function handle($arguments)
    {
        if (is_null($this->telegramUser))
        {
            TelegramUser::create([
                'id' => \Telegram::getWebhookUpdate()->getMessage()->getFrom()->getId()
            ]);
            $this->replyWithMessage(['text' => 'You have successfully started using the bot.']);
        }
    }
}
