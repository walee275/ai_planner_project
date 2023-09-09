<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Task;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Jobs\ProcessTaskDetails;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::with('tasks')->get();
        return view('frontend.home');
    }

    /**
     *
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd(Auth::id());
        return view('frontend.create_plan');
    }

    public function request_gpt(Request $request)
    { {
            // $message =
            // 'this prompt is being asked to you using an openai API. So if the prompt is not asking you queries  about creation of a plan for something, or if its not about a plan then respond "You can only ask for any plan creation".tasks title can only be a string if you want to use numbers use them like strings. And your response should be a plan and the tasks for the plan. This response should be in an array proper structured.Your response structure should be like this ( { plan:sure here is the plan for {here will be the plan title the user asked for}, then there will be the array of the tasks for the plan likt this, tasks:{task:"task title", description:"description"}}

            // prompt: '.$request->prompt .'.' ;

            $message =
                'this prompt is being asked to you using an openai API.
                So if the prompt is not asking you queries  about creation of a plan
                for something, or if its not about asking you for like creating any
                strategy,plan,or you giving the path way of something. then respond
                "You can only ask for any plan creation".Your response structure should
                be like this ( <p> sure here is the plan for {here will be the plan
               title the user asked for}</p>, then there will be an ul list of the
               plan\'s tasks where every list will have the task title in bold and description . And i also want a detailed explaination of every task in a div with class detailes and d-none.like this (<li><b> {task title here}:</b> {short description here} <div class="detailed-desc d-none">{detailed explaination here}</div></li>)  prompt: ' . $request->prompt . '.';
            // return response()->json($message);

            // $result = OpenAI::completions()->create([
            //     'model' => 'text-davinci-003',
            //     // 'prompt' => 'what is your name',
            //     'prompt' => 'i want to create a social media campaign to drive traffic to my website .
            //     give me the plan for it like tasks and keep all the tasks in an array',
            //     'max_tokens' => 4000,
            // ]);

            $result = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ])
                ->post("https://api.openai.com/v1/chat/completions", [
                    "model" => "gpt-3.5-turbo",
                    'messages' => [
                        [
                            "role" => "user",
                            "content" => $message,
                        ]
                    ],
                    'temperature' => 0.5,
                    "max_tokens" => 3000,
                    "top_p" => 1.0,
                    "frequency_penalty" => 0.52,
                    "presence_penalty" => 0.5,
                    "stop" => ["11."],
                ]);

            $response_content = Str::replace('\\n|\\\r|\\|', '', $result['choices'][0]['message']);

            // $result = json_encode($result['choices'][0]['message']['content']);
            return response()->json($response_content, 200, array(), JSON_PRETTY_PRINT);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = OpenAI::completions()->create([
            'model' => 'gpt-3.5-turbo',
            // 'prompt' => 'what is your name',
            'prompt' => 'i want to create a social media campaign to drive traffic to my website .
            give me the plan for it like tasks and keep all the tasks in an array',
            'max_tokens' => 4000,
        ]);
        dd($result);
        return json_encode($result->choices[0]->text);
    }

    /**
     * Display the specified resource.
     */

    public function create_plan(Request $request)
    {

        $plan = $request->plan;
        $tasks = $request->tasksList;
        $update_tasks_list = [];
        if (!empty($plan)) {

            $data = [
                'title' => $plan,
                'description' => '',
                'user_id' => $request->user,
            ];

            $plan_created = Plan::create($data);

            if ($plan_created && count($tasks)) {
                foreach ($tasks as $task) {

                    $data = [
                        'title' => $task['task'],
                        'description' => $task['description'],
                        'detailed_description' => $task['detailedDescription'],
                        'plan_id' => $plan_created->id,
                        'user_id' => $request->user,

                    ];

                    $task_added = Task::create($data);
                    $update_tasks_list[] = ['title' => $task['task'], 'task_id' => $task_added->id];
                }
                // dispatch(new ProcessTaskDetails());
                return response()->json(['success' => true, 'message' => 'Plan created successfully!']);
            } else {
                return response()->json(['success' => true, 'message' => 'plan added without any tasks successfully!']);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'Empty plan cannot be created!']);
        }
    }


    public function create_tasks(Request $request)
    {

        $plan_title = $request->plan;
        $plan_description = '';
        if ($request->tasksList) {
            $plan_description = '<ol style="background: lightgray;padding: 27px;border-radius: 10px;">';

            foreach ($request->tasksList as $task) {

                $plan_description .= '<li class="mb-2 tasks_rows" data-taskTitle="' . $task['task'] . '" data-taskDesc="' . $task['description'] . '"><strong>' . $task['task'] . '</strong>' . $task['description'] . '</li>';
            }

            $plan_description .= '</ol>';
        }

        $data = [
            'title' => $plan_title,
            'description' => $plan_description,
            'user_id' => $request->user,
        ];

        $plan_created = Plan::create($data);

        if ($plan_created) {
            return response()->json(['success' => true, 'message' => 'Plan created successfully!']);
        } else {
            return response()->json(['error' => true, 'message' => 'plan cannot be created!']);
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
                $data = [
                    'detailed_description' => $response_content,
                ];

                $task_added = Task::find($task['task_id'])->update($data);
            }
            return true;;
        }
    }

    public function show(Plan $plan)
    {
        $plans = Plan::with('tasks')->where('user_id', Auth::id())->orderBy('id', 'DESC')->get();

        return view('frontend.plans_show', compact('plans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
