<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Giveaway;
use App\Models\User;
use App\Notifications\NotifyGiveawayWinner;
use PO;

class GiveawayHandle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:giveaway-handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //reward
        

        $latest_ga = Giveaway::where('status', 'active')->orderBy('id', 'desc')->first();

        if (!is_null($latest_ga)) {
            $this->info('Giveaway active found');
            //reward
            $participants_count = User::where('giveaway', 1)->count();
            $winner = User::where('giveaway', 1)->inRandomOrder()->first();
            if (!is_null($winner)) {
                $this->info('Reward the user #' . $winner->id);
                $latest_ga->winner_id = $winner->id;
                $winner->robux = $winner->robux + $latest_ga->reward;
                $winner->save();
                $winner->notify(new NotifyGiveawayWinner());
            }  else {
                $this->info('No winner today');
            }
            $latest_ga->status = 'finished';
            $latest_ga->participants_count = $participants_count;
            $latest_ga->save();

            // reset participants
            User::where('giveaway', 1)->update(['giveaway' => 0]);
        } else {
            $this->info('No active giveaway found');
        }

        //start next giveaway
        sleep(2); // idk, just to be sure next time will be new
        // Determine next giveaway time
        // We have 3 giveaways: 11:00, 15:00, 20:00
        // I need difference in seconds between now and next giveaway
        \date_default_timezone_set('Europe/Moscow'); // Set your timezone
        // Current time
        $now = new \DateTime();

        // Target times today
        $times = [
            new \DateTime('today 11:00:00'),
            new \DateTime('today 15:00:00'),
            new \DateTime('today 20:00:00'),
            new \DateTime('tomorrow 11:00:00')
        ];

        $smallest_diff = PHP_INT_MAX;
        $closest_time = null;

        foreach ($times as $time) {
            // Calculate the difference
            $diff = $now->diff($time);
            $seconds = ($diff->days * 24 * 60 * 60) + ($diff->h * 60 * 60) + ($diff->i * 60) + $diff->s;

            // If the target time is in the future and the difference is smaller than the current smallest difference
            if ($now < $time && $seconds < $smallest_diff) {
                $smallest_diff = $seconds;
                $closest_time = $time;
            }
        }
        $new_ga = new Giveaway([
            'finalization_date' => $closest_time,
            'reward' => 100,
        ]);
        $new_ga->save();

        $this->info('Giveaway created');
    }
}
