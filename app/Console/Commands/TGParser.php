<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TGParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tg-parser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pings the parser docker container which parses and publishes a new post in the channel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $last_id = false;
        try {
            if (Storage::has('last_id.txt'))
                $last_id = Storage::read('last_id.txt');

            if (!$last_id) {
                $last_id = 31357;
            }

            $response = Http::post('http://parser_server.tonyandr.com/fetch-html', [
                'last_id' => $last_id
            ]);
            if ($response->status() === 200) {
                $decoded_json = $response->json();
                if (isset($decoded_json['last_post_id'])) {
                    Storage::write('last_id.txt', $decoded_json['last_post_id']);
                }
            } else {
                throw new Exception($response->body());
            }

            $this->info('Parsing complete: ' . $decoded_json['last_post_id']);
        } catch (Exception $e) {
            $this->info('Parsing Error: ' . $e->getMessage());
        }
    }
}
