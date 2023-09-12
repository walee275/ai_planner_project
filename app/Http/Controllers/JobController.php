<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function dispatch_job(){

        $data = [
            'title' => 'Task 3',
            'description' => 'Task description 3',
            'user_id' => 6
        ];
        dispatch(new TestJob());

        dd('Job created successfully;');

    }
}
