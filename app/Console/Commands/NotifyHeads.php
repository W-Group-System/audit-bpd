<?php

namespace App\Console\Commands;

use App\CorrectiveActionRequest;
use App\Mail\NotifyHeads as MailNotifyHeads;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyHeads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:notify_heads';

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
        $users = User::whereIn('role_id',[2,4])->get();
        foreach($users as $user)
        {
            $corrective_action_requests = CorrectiveActionRequest::with('correctiveAction','department')->where('auditee_id', $user->id)->get();
            if(count($corrective_action_requests) > 0)
            {
                Mail::to($user->email)->send(new MailNotifyHeads($corrective_action_requests));
            }
        }
    }
}
