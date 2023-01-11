<?php

namespace App\Jobs;

use App\Models\Clan;
use App\Models\DropLog;
use App\Services\ChatLogPatterns;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DropLogParser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $message;
    private Clan $clan;
    /**
     * @var null
     */
    private $overRideDate;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Clan $clan, string $message, $overRideDate = null)
    {
        //
        $this->message = $message;
        $this->clan = $clan;
        $this->overRideDate = $overRideDate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $matches = [];
        $result = preg_match(ChatLogPatterns::$dropLogPattern, $this->message, $matches);
        if ($result != 1) {
            return;
        }

        $rsnMatch = $matches[1];
        $string = htmlentities($rsnMatch, ENT_HTML5, 'utf-8');
        $content = str_replace("&nbsp;", " ", $string);
        $cleanName = html_entity_decode($content);

        $itemMatch = $matches[4];
        $quantityMatch = $matches[2] == '' ? 1 : $matches[2];
        $price = intval(str_replace(',', '', $matches[5]));
        $values = [
            'rsn' => $cleanName,
            'item_name' => $itemMatch,
            'price' => $price,
            'clan_id' => $this->clan->id,
            'quantity' => $quantityMatch
        ];
        if ($this->overRideDate != null) {
            $values['created_at'] = $this->overRideDate;
        }

        DropLog::create($values);

    }
}
