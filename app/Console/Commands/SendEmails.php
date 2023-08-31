<?php

namespace App\Console\Commands;

use App\Mail\LoanReminderMail;
use App\Models\LoanEntry;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to loaners';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->sendMail(1);
        $this->sendMail(7);

        return Command::SUCCESS;
    }

    private function sendMail(int $days): void
    {
        $loanEntries = LoanEntry::where('due_at', 'like', now()->addDays($days)->toDateString() . '%')->get();
        $loansPerUser = [];
        foreach ($loanEntries as $key) {
            if ($key->remainingAmount() > 0) {
                $loansPerUser[$key->user_id][] = $key;
            }
        }

        collect($loansPerUser)->each(function ($loanEntry) use ($days) {

            $user = $loanEntry[0]->user;
            $mailData = [
                'title' => 'Lening herinnering',
                'days' => $days,
                'products' => $loanEntry,
                'user' => $user
            ];


            Mail::to($user->email)->send(new LoanReminderMail($mailData));
        });
    }
}
