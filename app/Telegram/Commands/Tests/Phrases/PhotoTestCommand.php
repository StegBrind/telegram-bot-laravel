<?php

namespace App\Telegram\Commands\Tests\Phrases;

use App\Telegram\Interfaces\ExtraCommandInfo;
use Telegram\Bot\Commands\Command;

class PhotoTestCommand extends Command implements ExtraCommandInfo
{
    public $name = 'Photo test';

    public function isHidden(): bool
    {
        return false;
    }

    public function isPhrase(): bool
    {
        return true;
    }

    public function handle($arguments)
    {
        $reply_markup = json_encode([
            'inline_keyboard' =>
                [
                    /*first row*/
                    [
                        ['text' => 'Send one more time', 'callback_data' => 'Photo test']
                    ]
                ]
        ]);

        $this->replyWithMessage([
            'text' => 'Inline photo' . PHP_EOL . asset('storage/uploads/test.jpg'),
            'parse_mode' => 'html',
            'reply_markup' => $reply_markup
        ]);
    }
}
