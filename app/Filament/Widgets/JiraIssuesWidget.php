<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Http;

class JiraIssuesWidget extends Widget
{
    protected static string $view = 'filament.widgets.jira-issues-widget';

    public $data;

    public function mount()
    {
        $this->data = Http::withBasicAuth('rafiaziz12764@gmail.com', 'ATATT3xFfGF0VLJU4HvTCs_u_28OYDCXNVGqTofoZVqckONf67URVbzpzxxdZBGutT7eto_BrXQKC9R2GgPFLHSlTYitVEbFSEWWsBI14gzpLHqt1RZD3lmEbsuA-LibCcDp_K4-bdxLn92JjUHJ_s7cCKwBkz8PDs4I3t8YVPhCXZZtdE6WIeA=023351C9')
                        ->accept('application/json')
                        ->get('https://rafiaziz12764.atlassian.net/rest/api/3/issue/createmeta')
                        ->json();
    }
}
