<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Models\Donation;
use App\Models\DonationType;
use App\Models\RunescapeUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

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

    public function addDonationType_post(Request $request)
    {
        $clan = $request->get('clan');
        $requestJson = $request->json()->all();

        //TODO and add check for clan
        $donationType = DonationType::where('name', '=', $requestJson['name'])->where('clan_id', '=', $clan->id)
            ->first();

        if ($donationType) {
            return response(["message" => "This donation type already exists."], 409);
        }

        $newDonationType = new DonationType();
        $newDonationType->name = $requestJson['name'];
        $newDonationType->clan_id = $clan->id;
        $newDonationType->save();

        return response($newDonationType);

    }

    public function removeDonationType_delete(Request $request)
    {
        $clan = $request->get('clan');
        $requestJson = $request->json()->all();

        $donationType = DonationType::where('name', '=', $requestJson['name'])
            ->where('clan_id', '=', $clan->id)
            ->first();

        if($donationType){
            $donationType->delete();
            return response($donationType);
        }

        return response(["message" => "The donation type was not found or does not exist currently."], 409);
    }

    public function listTopDonatorsByType_post(Request $request)
    {
        $clan = $request->get('clan');
        $requestJson = $request->json()->all();

        $donationType = DonationType::where('name', '=', $requestJson['name'])
            ->where('clan_id', '=', $clan->id)
            ->first();

        if(!$donationType){
            return response(["message" => "That donation type does not exist", 409]);
        }

        $donations = Donation::where('donation_type_id', '=', $donationType->id)->get();
        $donatorsArray = array();
        foreach($donations as $donation){
            $user = RunescapeUser::where('id', '=', $donation->runescape_user_id)->first();
            $amount = $donation->amount;
            array_push($donatorsArray, ["name" => $user->username, "amount" => $amount]);
        }
        $donators = collect($donatorsArray);

        $uniqueDonators = $donators->pluck('name')->unique();
        $uniqueDonatorsWithTotals = [];
        foreach ($uniqueDonators as $user) {
            $sum = $donators->where('name', '=', $user)->sum('amount');
            array_push($uniqueDonatorsWithTotals, ["name" => $user, "total" => $sum]);
        };

        $result = Arr::sort($uniqueDonatorsWithTotals, function($donator) {
            return $donator['total'];
        });

        $resultReversed = array_reverse($result);

        if(count($resultReversed) <= 5){
            $resultReversed = array_slice($resultReversed, 0, 5);
        }

        return response($resultReversed);


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
