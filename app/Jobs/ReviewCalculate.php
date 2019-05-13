<?php

namespace App\Jobs;

use App\Models\Reviews;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ReviewCalculate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $review;

    /**
     * Create a new job instance.
     *
     * @param Reviews $reviews
     */
    public function __construct(Reviews $reviews)
    {
        $this->review = $reviews;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info($this->review->toArray());
    }
}
