<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Task;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::with('tasks')->get();


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.create_plan');
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

    public function create_plan(Request $request){

        // return response()->json($request->all());

        $plan = $request->plan;
        // return response()->json([$plan, $request->all()]);
        $tasks = $request->tasks;

        if(!empty($plan)){

            $data = [
                'title' => $plan,
                'description' => '',
            ];

            $plan_created = Plan::create($data);

            if($plan_created && count($tasks)){

                foreach($tasks as $task){
                    $data = [
                        'title' => $task['task'],
                        'description' => $task['description'],
                        'plan_id' => $plan_created->id,
                    ];

                    $task_added = Task::create($data);
                }

                return response()->json(['success' => true, 'message' => 'Plan created successfully!']);

            } else{
                return response()->json(['success' => true, 'message' => 'plan added without any tasks successfully!']);

            }
        }else{
            return response()->json(['error' => true, 'message' => 'Empty plan cannot be created!']);

        }
    }

    public function show(Plan $plan)
    {
        $plans = Plan::with('tasks')->get();

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
