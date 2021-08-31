<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Models\Donation;
use App\Models\DonationType;
use App\Models\RunescapeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonationsController extends Controller
{
    //
    public function addDonation_post(Request $request)
    {
        //TODO add a check if donation should count towards pot

        $clan = $request->get('clan');
        $requestJson = $request->json()->all();

        $donationType = DonationType::where("name", "=", $requestJson["donationType"])->where('clan_id', '=', $clan->id)->first();
        if ($donationType == null) {
            return response(["message" => "This donation type is not valid"], 409);
        }

        $amountFromRequest = $requestJson["amount"];
        $amount = null;
        if (Str::endsWith($amountFromRequest, "m")) {

            $amount = $this->parseAmount($amountFromRequest, "m");
        }

        if (Str::endsWith($amountFromRequest, "k")) {
            $amount = $this->parseAmount($amountFromRequest, "m");
        }

        if ($amount == null) {
            return response(["message" => "There was an issue parsing the amount"], 409);
        }

        $runescapeUser = RunescapeUser::where("username", "=", $requestJson['username'])->first();
        if ($runescapeUser == null) {
            return response(["message" => "We could not find the user making this donation"], 409);
        }

        $newDonation = new Donation();
        $newDonation->amount = $amount;
        $newDonation->runescape_user_id = $runescapeUser->id;
        $newDonation->donation_type_id = $donationType->id;
        $newDonation->save();

        $allDonationsAmount = Donation::where('runescape_user_id', '=', $runescapeUser->id)->get()->sum('amount');

        return response(["total" => number_format($allDonationsAmount)]);

    }

    public function addDonationType_post(Request $request, $discordServerId, $usersDiscordId)
    {
        //TODO add this check to a middleware and in header
        $runescapeUserMakingRequest = RunescapeUser::where('discord_id', '=', $usersDiscordId)->first();
        ray($runescapeUserMakingRequest);

        if (!$runescapeUserMakingRequest) {
            return response(["message" => "Appears your discord user has not been setup"], 409);
        }

        if (!$runescapeUserMakingRequest->admin) {
            return response(["message" => "Only admins can do this action. Git Gud."], 409);
        }
        $clan = Clan::where('discord_server_Id', '=', $discordServerId)->first();
        if (!$clan) {
            return response(["message" => "The clan has not been setup."], 409);
        }

        $requestJson = $request->json()->all();

        //TODO and add check for clan
        $donationType = DonationType::where('name', '=', $requestJson['name']);

    }

    public function listDonations_post(Request $request)
    {
        $clan = $request->get('clan');
        $requestJson = $request->json()->all();

        if ($requestJson["type"] == "all") {
            $donationTypes = DonationType::where('clan_id', '=', $clan->id)->get();
            $responseArray = array();
            foreach ($donationTypes as $donationType) {

                $total = Donation::where('donation_type_id', '=', $donationType->id)->sum('amount');
                $result = ["name" => $donationType->name, "total" => $total];
                array_push($responseArray, $result);
            }

            $responseArrayAsCollection = collect($responseArray);
            $grandTotal = $responseArrayAsCollection->sum('total');
            $withFormatting = $responseArrayAsCollection->map(function ($item) {
                $item["formattedAmount"] = number_format($item["total"]);
                return $item;
            });
            return response(["donationTypes" => $withFormatting, "grandTotal" => number_format($grandTotal)],);
        }

        if ($requestJson["type"] == "donationType") {
            $donationType = DonationType::where('name', '=', $requestJson["lookupId"])->first();
            if (!$donationType) {
                return response(["message" => "That donation type was not found"], 409);
            }

            //Hack
            $donations = Donation::where('donation_type_id', '=', $donationType->id)->get();

            if (count($donations) == 0) {
                return response(["name" => $donationType->name, "total" => "No donations made"],);

            }

            $total = $donations->sum('amount');
            return response(["name" => $donationType->name, "total" => number_format($total)],);
        }

        if ($requestJson["type"] == "user") {
            $runescapeUser = RunescapeUser::where("username", "=", $requestJson['lookupId'])->first();

            if ($runescapeUser == null) {
                return response(["message" => "We could not find the user making this donation"], 409);
            }
            //Hack
            $donations = Donation::where('runescape_user_id', '=', $runescapeUser->id)->get();

            if (count($donations) == 0) {
                return response(["name" => $runescapeUser->username, "total" => "No donations made"],);

            }
            $total = $donations->sum('amount');
            return response(["name" => $runescapeUser->username, "total" => number_format($total)],);

        }


    }

    private function parseAmount($amount, $amountType)
    {
        $splitAmount = explode($amountType, $amount);

        $numericAmount = intval($splitAmount[0]);
        if (!is_int($numericAmount)) {
            return null;
        }

        $multiplyBy = intval($amountType == "m" ? 1000000 : 1000);
        return $numericAmount * $multiplyBy;
    }


}
