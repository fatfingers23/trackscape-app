<?php

namespace Tests\Feature\Services;

use Tests\TestCase;

class HiscoreTest extends TestCase
{

    public function test_parseHisore()
    {
        //HACK Should really put this in a service or helper.
        $hiscoreDataRaw = file_get_contents("https://secure.runescape.com/m=hiscore_oldschool/index_lite.ws?player=fatfingersim");
        $skillHiscoreCount = 23;
        $hiscoreData = explode("\n", $hiscoreDataRaw);
        $stringToHash = "";

        for ($i = 0; $i <= $skillHiscoreCount; $i++) {
            $skillData = explode(",", $hiscoreData[$i]);
            $stringToHash .= $skillData[1] . $skillData[2];
        }


        $restOfHiscore = array_splice($hiscoreData, $skillHiscoreCount + 1);
        foreach ($restOfHiscore as $item) {
            $splitItem = explode(',', $item);
            if ($item != "") {
                $stringToHash .= $splitItem[1];
            }

        }

        ray(md5($stringToHash));
    }

}
