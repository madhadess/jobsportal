<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ServiceRequest;
use App\Services\MatchingService;
use Illuminate\Support\Facades\Log;

class ProcessServiceRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'matching:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process pending service requests and auto-assign personnel';

    protected $matchingService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MatchingService $matchingService)
    {
        parent::__construct();
        $this->matchingService = $matchingService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting service request processing...');

        $pendingRequests = ServiceRequest::pendingMatching()
            ->where('matching_attempts', '<', 5)
            ->get();

        $this->info("Found {$pendingRequests->count()} pending requests.");

        foreach ($pendingRequests as $request) {
            $this->info("Processing Request #{$request->request_number}");

            try {
                $match = $this->matchingService->findMatch($request);

                if ($match) {
                    $this->matchingService->assign($request, $match);
                    $this->info("Request #{$request->request_number} assigned to User ID {$match->id}.");

                    // TODO: Send Notifications here
                    // $match->notify(new ServiceAssigned($request));
                    // $request->user->notify(new PersonnelAssigned($request, $match));

                } else {
                    $request->increment('matching_attempts');
                    $this->warn("No match found for Request #{$request->request_number}. Attempt {$request->matching_attempts}.");

                    if ($request->matching_attempts >= 3) {
                        $request->automation_status = 'failed'; // Or 'admin_review'
                        $request->save();
                        $this->error("Request #{$request->request_number} marked as failed after 3 attempts.");
                    }
                }

            } catch (\Exception $e) {
                Log::error("Error processing request #{$request->id}: " . $e->getMessage());
                $this->error("Error processing request #{$request->request_number}: " . $e->getMessage());
            }
        }

        $this->info('Processing complete.');
        return 0;
    }
}
