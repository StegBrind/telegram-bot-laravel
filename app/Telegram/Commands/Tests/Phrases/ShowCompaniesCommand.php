<?php

namespace App\Telegram\Commands\Tests\Phrases;

use App\TestModels\Company;
use App\Telegram\Interfaces\ExtraCommandInfo;
use App\Telegram\Interfaces\StepByStep;
use App\Telegram\Traits\StepsReproducer;
use App\Telegram\BaseClasses\Command;

class ShowCompaniesCommand extends Command implements StepByStep, ExtraCommandInfo
{
    use StepsReproducer;

    public $name = 'View companies';

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
            function ()
            {
                $company = Company::where('name', '=', $this->update->getMessage()->getText())->get();
                if ($company->isEmpty())
                {
                    $this->replyWithMessage(['text' => 'The company was not found']);
                }
                else
                {
                    $company = $company->toArray()[0];
                    $company['is_active'] = $company['is_active'] ? '<b>Active</b> ✅' : '<b>Inactive</b> ❌';
                    $this->replyWithMessage(['text' =>
                        "Company name: <b>{$company['name']}</b>" . PHP_EOL . PHP_EOL .
                        "Description: <b>{$company['description']}</b>" . PHP_EOL .
                        "Status: " . $company['is_active']
                        , 'parse_mode' => 'HTML']);
                }
            }
        ];
    }

    public function mainStep(): void
    {
        $companies = Company::select('name')->get()->toArray();
        if (empty($companies))
        {
            $this->replyWithMessage(['text' => 'No companies.']);
            return;
        }

        $this->telegramUser->update([
            'current_action' => ['command' => 'View companies', 'step' => 0]
        ]);

        $companies_count = count($companies);

        for ($i = 0; $i < $companies_count; $i++)
        {
            $companies[$i] = [$companies[$i]['name']];
        }
        $this->replyWithMessage([
            'text' => 'Select company',
            'reply_markup' => json_encode([
                'keyboard' => array_merge($companies, [['Back to Main menu']]),
                'resize_keyboard' => true
            ])
        ]);
    }
}
