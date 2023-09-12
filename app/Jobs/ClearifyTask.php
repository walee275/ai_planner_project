<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ClearifyTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tasks = [];
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->tasks = Task::where('detailed_description', null)->get();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tasks = $this->tasks;

        // $prompt = $task['title'] . 'i want detailed explanation of this in an array where every single point will be on a single index as a string and the point should be well explained in detail';
        //
    }
}
