<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MatchPendingServiceRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'match:requests';
    protected $description = 'Match pending service requests with available personnel';

    public function handle()
    {
        $pendingRequests = \App\ServiceRequest::where('automation_status', 'pending_matching')
            ->where('status', \App\ServiceRequest::STATUS_PENDING)
            ->get();

        $this->info("Found " . $pendingRequests->count() . " pending requests.");

        foreach ($pendingRequests as $request) {
            $this->info("Processing Request #{$request->request_number}...");

            $personnel = $request->findBestMatchingPersonnel();

            if ($personnel) {
                $request->matched_personnel_id = $personnel->id;
                $request->automation_status = 'matched';
                $request->save();

                $this->info("Successfully matched Request #{$request->request_number} with Personnel #{$personnel->id} ({$personnel->getName()})");
            } else {
                $request->matching_attempts += 1;
                if ($request->matching_attempts >= 5) {
                    $request->automation_status = 'failed';
                    $request->save();

                    // Notify Customer about failure
                    try {
                        $customer = \App\User::find($request->user_id);
                        if ($customer) {
                            $customer->notify(new \App\Notifications\MatchingFailed($request));
                            $this->info("Failure notification sent to Customer {$customer->id}");
                        }
                    } catch (\Exception $e) {
                        $this->error("Notification Error: " . $e->getMessage());
                    }
                } else {
                    $request->save();
                }
                $this->error("No matching personnel found for Request #{$request->request_number}. Attempt: {$request->matching_attempts}");
            }
        }

        return 0;
    }
}
