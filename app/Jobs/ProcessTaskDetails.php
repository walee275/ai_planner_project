<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessTaskDetails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $updateTasksList;
    public $tries = 1;
    public function __construct()
    {
        // $this->updateTasksList = $updateTasksList;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {


        try {
            $data = [
                [
                    'task' => 'Task 1',
                    'description' => 'Description for Task 1',
                    'user_id' => 6,
                ],
                [
                    'task' => 'Task 2',
                    'description' => 'Description for Task 2',
                    'user_id' => 6,
                ],
                // Add more tasks as needed
            ];
            // Call your get_task_details function here
            // Log::info('Task details processing started');

            // $this->get_task_details($this->updateTasksList);
            Task::create($data);

            Log::info('Task details processing completed.');
        } catch (\Exception $e) {
            Log::error('Error processing task details: ' . $e->getMessage());
        }
    }

    public function get_task_details($tasks = [])
    {

        if ($tasks) {

            foreach ($tasks as $task) {

                $result = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                ])
                    ->post("https://api.openai.com/v1/chat/completions", [
                        "model" => "gpt-3.5-turbo",
                        'messages' => [
                            [
                                "role" => "user",
                                "content" => 'Explain this in detail' . $task['title'],
                            ]
                        ],
                        'temperature' => 0.5,
                        "max_tokens" => 1000,
                        "top_p" => 1.0,
                        "frequency_penalty" => 0.52,
                        "presence_penalty" => 0.5,
                        "stop" => ["11."],
                    ]);

                $response_content = Str::replace('\\n|\\\r|\\|', '', $result['choices'][0]['message']);
                $task['detailed_description'] = $response_content;
            }
            foreach ($tasks as $task) {
                $data = [
                    'detailed_description' => $task['detailed_description'],
                ];

                $task_added = Task::find($task['task_id'])->update($data);
            }
            return true;;
        }
    }
}
