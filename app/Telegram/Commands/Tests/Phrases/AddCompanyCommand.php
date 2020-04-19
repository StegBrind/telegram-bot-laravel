<?php

namespace App\Telegram\Commands\Tests\Phrases;

use App\TestModels\Company;
use App\Telegram\Interfaces\ExtraCommandInfo;
use App\Telegram\Interfaces\StepByStep;
use App\Telegram\Traits\StepsReproducer;
use App\Telegram\BaseClasses\Command;

class AddCompanyCommand extends Command implements StepByStep, ExtraCommandInfo
{
    use StepsReproducer {
        handle as protected parentHandle;
    }

    public $name = 'Add company';

    public function isHidden(): bool
    {
        return false;
    }

    public function isPhrase(): bool
    {
        return true;
    }

    public function __construct()
    {
        $this->steps =
        [
            function ($message, $step, $goBack)
            {
                $this->replyWithMessage([
                    'text' => 'Type in company description',
                    'reply_markup' => json_encode([
                        'keyboard' => [['Back'], ['Back to Main menu']],
                        'resize_keyboard' => true
                    ])
                ]);

                if ($goBack)
                    $this->setStep($step + 1);
                else
                    $this->setStep(1, ['company_name' => $message->getText()]);
            },
            function ($message, $step, $goBack)
            {
                $this->replyWithMessage([
                    'text' => 'Select status',
                    'reply_markup' => json_encode([
                        'keyboard' => [
                            ['Active', 'Inactive'],
                            ['Back'],
                            ['Back to Main menu']
                        ],
                        'resize_keyboard' => true
                    ])
                ]);

                if ($goBack)
                    $this->setStep($step + 1);
                else
                    $this->setStep(2, ['company_description' => $message->getText()]);
            },
            function ($message, $step, $goBack)
            {
                if ($message->getText() != 'Active' && $message->getText() != 'Inactive')
                    return;

                $current_action = $this->telegramUser->current_action;
                Company::create(['name' => $current_action['company_name'], 'description' => $current_action['company_description'],
                    'is_active' => $message->getText() == 'Active' ? 1 : 0]);

                $this->telegramUser->update(['current_action' => '{}']);

                $this->replyWithMessage([
                    'text' =>
                        'The company has been successfully created.' . PHP_EOL . PHP_EOL .
                        "Name: <b>{$current_action['company_name']}</b>" . PHP_EOL .
                        "Description: <b>{$current_action['company_description']}</b>" . PHP_EOL .
                        "Status: <b>{$message->getText()}</b>",
                    'parse_mode' => 'HTML'
                ]);

                $this->triggerCommand('Main menu');
            }
        ];
    }

    public function handle($arguments)
    {
        if ($this->update->getMessage()->getText() == 'Back')
        {
            $this->reproduceStep($this->telegramUser->current_action['step'] - 2, true);
            return;
        }

        $this->parentHandle($arguments);
    }

    public function mainStep(): void
    {
        $this->telegramUser->current_action = ['command' => 'Add company', 'step' => 0];

        $this->telegramUser->save();

        $this->replyWithMessage([
            'text' => 'Type in company name',
            'reply_markup' => json_encode([
                'keyboard' => [['Back to Main menu']],
                'resize_keyboard' => true
            ])
        ]);
    }
}
