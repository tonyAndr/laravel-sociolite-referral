<?php

namespace App\Listeners;

use App\Events\ReferralCompleted;
use App\Events\ReferralDetected;
use App\Events\WithdrawalCancelled;
use App\Events\WithdrawalPlaced;
use App\Mail\WithdrawalCancelledMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Referral;
use Illuminate\Support\Facades\Mail;

class AddWithdrawalToSpreadsheet
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WithdrawalPlaced $event): void
    {
        //
        $withdrawal_data = $event->data;
        $this->addRow($withdrawal_data);
    }

    private function addRow($data)
    {
        $spreadsheet_id = "1mWmWezixJiDf9_n04mJjH6tge_1Y1ZMd3Ed44QmREnk";
        // dirty way
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets API');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        // credentials.json is the key file we downloaded while setting up our Google Sheets API
        $path =  base_path('google_api_credentials.json');
        $client->setAuthConfig($path);

        // configure the Sheets Service
        $service = new \Google_Service_Sheets($client);
        // the spreadsheet id can be found in the url https://docs.google.com/spreadsheets/d/143xVs9lPopFSF4eJQWloDYAndMor/edit

        $spreadsheetId = $spreadsheet_id;
        // $spreadsheet = $service->spreadsheets->get($spreadsheetId);
        $newRow = [
            $data->id,
            $data->user_id,
            $data->created_at,
            $data->amount,
            $data->gamepass_url,
        ];
        $rows = [$newRow]; // you can append several rows at once
        $valueRange = new \Google_Service_Sheets_ValueRange();
        $valueRange->setValues($rows);
        $range = 'Лист1'; // the service will detect the last row of this sheet
        $options = ['valueInputOption' => 'USER_ENTERED'];
        $service->spreadsheets_values->append($spreadsheetId, $range, $valueRange, $options);
    }
}
