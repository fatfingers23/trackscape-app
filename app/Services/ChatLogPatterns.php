<?php

namespace App\Services;


class ChatLogPatterns
{
    public static string $collectionLogPattern = '/(.*) received a new collection log item: [^0-9]*(.*)\)$/';

    public static string $personalBestPattern = '/(.*) has achieved a new (.*) personal best: (.*)/';

    //TODO need to add the actual regex for K/D
    public static string $pkMade = "Mambofisk has defeated CoxCuck and received (4,052,060 coins) worth of loot!";

    public static string $pkDeath = "The_AllMeaty has been defeated by R 66 and lost (109 coins) worth of loot.";
}