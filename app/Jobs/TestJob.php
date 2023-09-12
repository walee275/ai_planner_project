<?php

namespace App\Jobs;

use App\Models\Task;
use Dotenv\Util\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $task;
    protected $timeout = 0; // No timeout
    /**
     * Create a new job instance.
     */
    public function __construct($task = [])
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {


            $task_title = $this->task['task_title'];
            $description = $this->task['description'];

            $prompt = $task_title . $description . '.  ';

            $response = $this->get_task_explanation($prompt);
            $data = [
                'detailed_description' => $response,
            ];




        $create = Task::find($this->task['task_id'])->update($data);

    }

    public function get_task_explanation($prompt)
    {
        //
        $result = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])
            ->post("https://api.openai.com/v1/chat/completions", [
                "model" => "gpt-3.5-turbo",
                'messages' => [
                    [
                        "role" => "user",
                        "content" => $prompt,
                    ]
                ],
                'temperature' => 0.5,
                "max_tokens" => 4000,
                "top_p" => 1.0,
                "frequency_penalty" => 0.52,
                "presence_penalty" => 0.5,
                "stop" => ["11."],
            ]);

            if (isset($result['choices'][0]['message']['content'])) {
                $response_content = str_replace('\\n|\\\r|\\|', '', $result['choices'][0]['message']['content']);
                return $response_content;
            } else {
                // Handle the case where the content is not present in the response.
                return "No content found in the response.";
            }
    }
}
