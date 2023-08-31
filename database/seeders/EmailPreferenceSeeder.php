<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailPreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = 'user_id';
        $reminder7Days = 'reminder_7_days';
        $reminderSameDay = 'reminder_same_day';
        $approvedOrDeniedMessage = 'approved_or_denied_message';

        $emailPreference = array();

        foreach (User::all() as $user) {
            $userPreference = [
                $userId => $user->id,
                $reminder7Days => 1,
                $reminderSameDay => 1,
                $approvedOrDeniedMessage => 0
            ];
            $emailPreference[] = $userPreference;

        }
        DB::table('email_preferences')->insert($emailPreference);


    }

}
