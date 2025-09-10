<?php

namespace App\Console\Commands;

use App\CorrectionImmediateAction;
use App\CorrectiveAction;
use App\CorrectiveActionRequest;
use App\Notifications\ForVerificationNotification;
use App\User;
use Illuminate\Console\Command;

class ForVerificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:for_verification_deadline';

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
        $corrective_action_requests = CorrectiveActionRequest::whereHas('correctiveAction', function($q) {
                $q->where('action_date', date('Y-m-d', strtotime("+5 days")));
            })
            ->orWhereHas('correctionImmediateAction', function($q) {
                $q->where('correction_action_date', date('Y-m-d', strtotime("+5 days")));
            })
            ->get();
        
        foreach($corrective_action_requests as $corrective_action_request)
        {
            $audit_head = User::where('role_id',4)->first();
            $audit_head->notify(new ForVerificationNotification($corrective_action_request));
            $corrective_action_request->auditor->notify(new ForVerificationNotification($corrective_action_request));
            $corrective_action_request->auditee->notify(new ForVerificationNotification($corrective_action_request));
        }
    }
}
