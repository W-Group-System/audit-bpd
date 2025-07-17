<?php

namespace App\Console\Commands;

use App\CorrectiveAction;
use App\CorrectiveActionRequestApprover;
use App\Mail\NotifyEmail as MailNotifyEmail;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notify_email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $auditors = [1, 4];
        $users = User::whereIn('role_id',$auditors)->get();
        foreach($users as $user)
        {
            $car_approvers = CorrectiveActionRequestApprover::with('correctiveActionRequest.correctiveAction')->where('user_id', $user->id)->where('status','Pending')->get();
            if(count($car_approvers) > 0)
            {
                Mail::to($user->email)->send(new MailNotifyEmail($car_approvers));
            }
        }
    }
}
