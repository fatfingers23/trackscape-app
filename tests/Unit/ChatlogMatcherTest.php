<?php

namespace Tests\Unit;

use App\Jobs\NewChatHandlerJob;
use App\Jobs\PersonalBestJob;
use App\Models\Clan;
use App\Services\ChatLogPatterns;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\TestCase;
use Tests\DataMocks\ChatLogMessages;

class ChatlogMatcherTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Tests the collection log pattern
     *
     * @return void
     */
    public function test_collectionLogPattern()
    {
        $message = "RSName received a new collection log item: Adamant full helm (t) (375/1422)";
        $matches = [];
        $result = preg_match(ChatLogPatterns::$collectionLogPattern, $message, $matches);
        $this->assertEquals(1, $result);
        $this->assertEquals('RSName', $matches[1]);
        $this->assertEquals('375/1422', $matches[2]);
    }

    /**
     * @param $expected
     * @param $message
     * @return void
     * @dataProvider personalBestTestData
     */
    public function test_personalBestPattern($expected, $message)
    {
        $matches = [];
        $result = preg_match(ChatLogPatterns::$personalBestPattern, $message, $matches);
        $this->assertEquals(1, $result);
        $this->assertEquals($expected['rsn'], $matches[1]);
        $this->assertEquals($expected['boss_name'], $matches[2]);
        $this->assertEquals($expected['kill_time'], $matches[3]);

    }

    /**
     * @param $expected
     * @param $message
     * @return void
     * @dataProvider personalBestTestData
     */
    public function test_MessageToModel($expected, $message)
    {
        Queue::fake();
        $clan = Clan::create([
            'name' => "Some Clan",
            'discord_server_id' => '123',
            'confirmation_code' => uniqid()
        ]);
        $matches = [];
        $result = preg_match(ChatLogPatterns::$personalBestPattern, $message, $matches);
        PersonalBestJob::dispatch($clan, $matches);

        Queue::assertPushed(PersonalBestJob::class, function ($job) {
            ray($job);
            return $job->data['action'] === 'deleteAllFiles';
        });
    }

    /**
     * @param $expected
     * @param $message
     * @return void
     * @dataProvider dropLogTestData
     */
    public function test_dropLogPattern($expected, $message)
    {
        $matches = [];
        //Below works

        $result = preg_match(ChatLogPatterns::$dropLogPattern, $message, $matches);
        $this->assertEquals(1, $result);
//        ray($matches);
        $this->assertEquals($expected['rsn'], $matches[1]);
        $this->assertEquals($expected['item_name'], $matches[4]);
        if ($expected['quantity'] > 1) {
            $this->assertEquals($expected['quantity'], $matches[2]);
        }
        $this->assertEquals($expected['price'], $matches[5]);

    }


    public function personalBestTestData()
    {
        return ChatLogMessages::personalBestTestData();
    }

    public function dropLogTestData()
    {
        return ChatLogMessages::dropLogTestData();
    }

}
