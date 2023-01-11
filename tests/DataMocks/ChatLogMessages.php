<?php

namespace Tests\DataMocks;

class ChatLogMessages
{
    public static function dropLogTestData()
    {
        return [
            [
                [
                    'rsn' => 'RSName',
                    'item_name' => 'Adamant full helm (t)',
                    'price' => 375,
                    'quantity' => 1
                ],
                'RSName received a drop: Adamant full helm (t) (375 coins).'
            ],
            [
                [
                    'rsn' => 'RS Name',
                    'item_name' => 'Snapdragon seed',
                    'price' => '360,736',
                    'quantity' => 8
                ],
                'RS Name received a drop: 8 x Snapdragon seed (360,736 coins).'
            ],
            [
                [
                    'rsn' => 'RS Name',
                    'item_name' => 'Abyssal whip',
                    'price' => '1,379,048',
                    'quantity' => 1
                ],
                'RS Name received a drop: Abyssal whip (1,379,048 coins).'
            ]
        ];

    }

    public static function personalBestTestData()
    {
        return [
            [
                ['kill_time' => '37:35.40', 'rsn' => 'RSName', 'boss_name' => 'Tombs of Amascut (team size: 1) Entry mode Overall',
                    'kill_in_seconds' => 2255]
                , 'RSName has achieved a new Tombs of Amascut (team size: 1) Entry mode Overall personal best: 37:35.40'
            ],
            [
                ['kill_time' => '37:10', 'rsn' => 'RSName', 'boss_name' => 'Tombs of Amascut (team size: 1) Normal mode Overall',
                    'kill_in_seconds' => 2230]
                , 'RSName has achieved a new Tombs of Amascut (team size: 1) Normal mode Overall personal best: 37:10'
            ],
            [
                ['kill_time' => '23:23', 'rsn' => 'RSName', 'boss_name' => 'Tombs of Amascut (team size: 1) Normal mode Challenge',
                    'kill_in_seconds' => 1403]
                , 'RSName has achieved a new Tombs of Amascut (team size: 1) Normal mode Challenge personal best: 23:23'
            ],
            [
                ['kill_time' => '1:17', 'rsn' => 'RSName', 'boss_name' => 'Zulrah',
                    'kill_in_seconds' => 77]
                , 'RSName has achieved a new Zulrah personal best: 1:17'
            ],
            [
                ['kill_time' => '1:32:25', 'rsn' => 'RSName', 'boss_name' => 'Chambers of Xeric (Team Size: 3 players)',
                    'kill_in_seconds' => 5545]
                , 'RSName has achieved a new Chambers of Xeric (Team Size: 3 players) personal best: 1:32:25'
            ],
            [
                ['kill_time' => '18:07.20', 'rsn' => 'RSName', 'boss_name' => 'Chambers of Xeric (Team Size: 3 players)',
                    'kill_in_seconds' => 1087]
                , 'RSName has achieved a new Chambers of Xeric (Team Size: 3 players) personal best: 18:07.20'
            ]
        ];
    }
}