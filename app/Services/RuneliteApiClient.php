<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class RuneliteApiClient
{

    protected string $baseUrl = "https://api.runelite.net/runelite-";

    private function getRuneliteVersion(): string
    {
        return Cache::remember('runelite-key', 3600, function () {
            $result = Http::get('https://raw.githubusercontent.com/runelite/runelite/master/runelite-api/pom.xml');
            if ($result->successful()) {
                $xml_string = $result->body();
                $xml = simplexml_load_string($xml_string);
                $json = json_encode($xml);
                $array = json_decode($json, TRUE);
                return $array['parent']['version'];
            } else {
                throw new \Exception('Could not get rune lite version');
            }
        });
    }

    private function buildBasedUrl(): string
    {
        return $this->baseUrl . $this->getRuneliteVersion();
    }

    public function getUsersPb(string $rsn, string $boss)
    {
        $fullBoss = $this->bossLongName($boss);
        $url = $this->buildBasedUrl() . "/chat/pb?name=$rsn&boss=$fullBoss";
        $result = Http::get($url);
        if ($result->successful()) {
            return intval($result->body());
        }
        return intval($result);
    }

    public function bossLongName(string $boss): string
    {
        switch (strtolower($boss)) {
            case "corp":
                return "Corporeal Beast";

            case "jad":
            case "tzhaar fight cave":
                return "TzTok-Jad";

            case "kq":
                return "Kalphite Queen";

            case "chaos ele":
                return "Chaos Elemental";

            case "dusk":
            case "dawn":
            case "gargs":
            case "ggs":
            case "gg":
                return "Grotesque Guardians";

            case "crazy arch":
                return "Crazy Archaeologist";

            case "deranged arch":
                return "Deranged Archaeologist";

            case "mole":
                return "Giant Mole";

            case "vetion":
                return "Vet'ion";

            case "vene":
                return "Venenatis";

            case "kbd":
                return "King Black Dragon";

            case "vork":
                return "Vorkath";

            case "sire":
                return "Abyssal Sire";

            case "smoke devil":
            case "thermy":
                return "Thermonuclear Smoke Devil";

            case "cerb":
                return "Cerberus";

            case "zuk":
            case "inferno":
                return "TzKal-Zuk";

            case "hydra":
                return "Alchemical Hydra";

            // gwd
            case "sara":
            case "saradomin":
            case "zilyana":
            case "zily":
                return "Commander Zilyana";
            case "zammy":
            case "zamorak":
            case "kril":
            case "kril trutsaroth":
                return "K'ril Tsutsaroth";
            case "arma":
            case "kree":
            case "kreearra":
            case "armadyl":
                return "Kree'arra";
            case "bando":
            case "bandos":
            case "graardor":
                return "General Graardor";

            // dks
            case "supreme":
                return "Dagannoth Supreme";
            case "rex":
                return "Dagannoth Rex";
            case "prime":
                return "Dagannoth Prime";

            case "wt":
                return "Wintertodt";
            case "barrows":
                return "Barrows Chests";
            case "herbi":
                return "Herbiboar";

            // cox
            case "cox":
            case "xeric":
            case "chambers":
            case "olm":
            case "raids":
                return "Chambers of Xeric";

            // cox cm
            case "cox cm":
            case "xeric cm":
            case "chambers cm":
            case "olm cm":
            case "raids cm":
            case "chambers of xeric - challenge mode":
                return "Chambers of Xeric Challenge Mode";

            // tob
            case "tob":
            case "theatre":
            case "verzik":
            case "verzik vitur":
            case "raids 2":
                return "Theatre of Blood";

            case "theatre of blood: story mode":
            case "tob sm":
            case "tob story mode":
            case "tob story":
            case "Theatre of Blood: Entry Mode":
            case "tob em":
            case "tob entry mode":
            case "tob entry":
                return "Theatre of Blood Entry Mode";

            case "theatre of blood: hard mode":
            case "tob cm":
            case "tob hm":
            case "tob hard mode":
            case "tob hard":
            case "hmt":
                return "Theatre of Blood Hard Mode";

            // agility course
            case "prif":
            case "prifddinas":
                return "Prifddinas Agility Course";

            // The Gauntlet
            case "gaunt":
            case "gauntlet":
            case "the gauntlet":
                return "Gauntlet";

            // Corrupted Gauntlet
            case "cgaunt":
            case "cgauntlet":
            case "the corrupted gauntlet":
            case "cg":
                return "Corrupted Gauntlet";

            // The Nightmare
            case "nm":
            case "tnm":
            case "nmare":
            case "the nightmare":
                return "Nightmare";

            // Phosani's Nightmare
            case "pnm":
            case "phosani":
            case "phosanis":
            case "phosani nm":
            case "phosani nightmare":
            case "phosanis nightmare":
                return "Phosani's Nightmare";

            // Hallowed Sepulchre
            case "hs":
            case "sepulchre":
            case "ghc":
                return "Hallowed Sepulchre";
            case "hs1":
            case "hs 1":
                return "Hallowed Sepulchre Floor 1";
            case "hs2":
            case "hs 2":
                return "Hallowed Sepulchre Floor 2";
            case "hs3":
            case "hs 3":
                return "Hallowed Sepulchre Floor 3";
            case "hs4":
            case "hs 4":
                return "Hallowed Sepulchre Floor 4";
            case "hs5":
            case "hs 5":
                return "Hallowed Sepulchre Floor 5";

            // Ape Atoll Agility
            case "aa":
            case "ape atoll":
                return "Ape Atoll Agility";

            // Draynor Village Rooftop Course
            case "draynor":
            case "draynor agility":
                return "Draynor Village Rooftop";

            // Al-Kharid Rooftop Course
            case "al kharid":
            case "al kharid agility":
            case "al-kharid":
            case "al-kharid agility":
            case "alkharid":
            case "alkharid agility":
                return "Al-Kharid Rooftop";

            // Varrock Rooftop Course
            case "varrock":
            case "varrock agility":
                return "Varrock Rooftop";

            // Canifis Rooftop Course
            case "canifis":
            case "canifis agility":
                return "Canifis Rooftop";

            // Falador Rooftop Course
            case "fally":
            case "fally agility":
            case "falador":
            case "falador agility":
                return "Falador Rooftop";

            // Seers' Village Rooftop Course
            case "seers":
            case "seers agility":
            case "seers village":
            case "seers village agility":
            case "seers'":
            case "seers' agility":
            case "seers' village":
            case "seers' village agility":
            case "seer's":
            case "seer's agility":
            case "seer's village":
            case "seer's village agility":
                return "Seers' Village Rooftop";

            // Pollnivneach Rooftop Course
            case "pollnivneach":
            case "pollnivneach agility":
                return "Pollnivneach Rooftop";

            // Rellekka Rooftop Course
            case "rellekka":
            case "rellekka agility":
                return "Rellekka Rooftop";

            // Ardougne Rooftop Course
            case "ardy":
            case "ardy agility":
            case "ardy rooftop":
            case "ardougne":
            case "ardougne agility":
                return "Ardougne Rooftop";

            // Agility Pyramid
            case "ap":
            case "pyramid":
                return "Agility Pyramid";

            // Barbarian Outpost
            case "barb":
            case "barb outpost":
                return "Barbarian Outpost";

            // Brimhaven Agility Arena
            case "brimhaven":
            case "brimhaven agility":
                return "Agility Arena";

            // Dorgesh-Kaan Agility Course
            case "dorg":
            case "dorgesh kaan":
            case "dorgesh-kaan":
                return "Dorgesh-Kaan Agility";

            // Gnome Stronghold Agility Course
            case "gnome stronghold":
                return "Gnome Stronghold Agility";

            // Penguin Agility
            case "penguin":
                return "Penguin Agility";

            // Werewolf Agility
            case "werewolf":
                return "Werewolf Agility";

            // Skullball
            case "skullball":
                return "Werewolf Skullball";

            // Wilderness Agility Course
            case "wildy":
            case "wildy agility":
                return "Wilderness Agility";

            // Jad challenge
            case "jad 1":
                return "TzHaar-Ket-Rak's First Challenge";
            case "jad 2":
                return "TzHaar-Ket-Rak's Second Challenge";
            case "jad 3":
                return "TzHaar-Ket-Rak's Third Challenge";
            case "jad 4":
                return "TzHaar-Ket-Rak's Fourth Challenge";
            case "jad 5":
                return "TzHaar-Ket-Rak's Fifth Challenge";
            case "jad 6":
                return "TzHaar-Ket-Rak's Sixth Challenge";

            // Guardians of the Rift
            case "gotr":
            case "runetodt":
                return "Guardians of the Rift";

            default:
                return ucwords($boss);
        }
    }
}