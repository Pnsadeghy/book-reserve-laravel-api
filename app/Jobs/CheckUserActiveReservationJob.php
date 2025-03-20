<?php

namespace App\Jobs;
class CheckUserActiveReservationJob
{
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // TODO check for books that are past their return date
        // TODO send notification to to offending users
    }
}
