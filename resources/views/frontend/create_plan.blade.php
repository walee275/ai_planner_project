@extends('layouts.frontend.main')

@section('title', 'Create a Plan')

@section('styles')
    <style>
        .textarea {
            border-radius: 20px;
            /* margin-top: 20px; */
        }

        .response_container {
            width: auto;
            height: 271px;
            border: 1px solid #b0d5de;
            border-radius: 12px;
            background: aliceblue;
            max-height: 100%;
            overflow-y: auto;

        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col text-right pr-4">
            <a href="{{ route('homepage') }}" class="btn">Back</a>
        </div>
    </div>
    <div id="data_container" class="p-3">
        <div class="row " style="margin-top: rem!important;">
            <div class="col">
                <textarea class="form-control textarea" rows="2" id="userPrompt"
                    placeholder="Create a plan for a social media campaign to drive traffic to my website for my new product"
                    style="font-size: small;"></textarea>

            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <button type="button" class="w-100 btn " style="" id="prompt_submit">
                    Submit</button>
            </div>
        </div>
        <div class="row mt-3" style="">

            <div class="col">
                <div class="response_container p-2 py-3" id="response_container"></div>
                {{-- <textarea class="form-control textarea" placeholder="Input 2" id="display_response" rows="10"></textarea> --}}

            </div>
        </div>
        <div class="row mt-2">
            <div class="col text-center">
                <button type="button" class="btn" id="createPlanButton"
                    style="">Create
                    Plan
                </button>
            </div>
            <div class="col text-center">
                <button type="button" class="btn" id="createTaskButton"
                    style="">Create
                    Task
                </button>

            </div>
        </div>
        <div class="row mt-4">
            <div class="col text-center">
                {{-- <p>We need permissions for the service you use <br> --}}
                    <a href="#" class="text-white">learn more</a>
                </p>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        let tasks = [];
        $(document).ready(function() {


            const userPrompt = $('#userPrompt').val();
            const responseContainer = $('#response_container');

            $('#prompt_submit').click(function(e) {
                e.preventDefault();
                tasks = [];
                if($('#userPrompt').val() == '' || $('#userPrompt').val() === undefined) {
                    $('#response_container').text('You cannot submit empty plan!');
                    return;
                }
                const data = {
                    prompt: $('#userPrompt').val(),
                }
                const btn = $(this);
                $(this).text('Loading...');
                fetch('{{ route('request_gpt') }}', {
                    method: 'POST',
                    body: JSON.stringify(data),
                    headers: {
                        'Content-Type': 'application/json',
                    }
                }).then(function(response) {
                    return response.json();
                }).then(function(result) {
                    // console.log(result);
                    btn.text('Submit');

                    result = result.content.replace(/\\n\\n|\r\r|\\ /g, '');

                    $('#response_container').html(result);
                    $("#response_container li").each(function() {
                        // Extract the text from the <b> tag
                        const taskText = $(this).find("b").text().trim();

                        // Extract the remaining text (description)
                        const descriptionText = $(this).clone().children().remove().end()
                            .text().trim();

                        // Append to the tasks array
                        tasks.push({
                            task: taskText,
                            description: descriptionText
                        });
                    });
                });
            })







            $('#createPlanButton').on('click', function() {
                const userPromptText = $('#userPrompt').val();
                const userPromptElement = $(
                    '<h4 class="mb-3 text-white" style=""></h4>').text(
                    userPromptText);

                $('#data_container').empty().append(userPromptElement);

                const responseContainer = $('#response_container');

                let taskTextareas = '';

                $.each(tasks, function(index, task) {
                    taskTextareas +=
                        `<label class="text-white"><b>${index+1} :</b>${task.task}</label><textarea class="form-control textarea" rows="3" disabled>${task.description}</textarea>`;
                    // taskTextareas.push(taskTextarea);
                });
                taskTextareas +=
                    `<div class="row mt-3 mb-4 "> <div class="col text-center"><button class="btn " data-plan="${userPromptText}" id="save_plan_btn" style="background: #5ce1e6 !important;border-radius:21px;height:35px; color:white;">Save Tasks</button></div>  </div>`
                $('#data_container').append(taskTextareas);
            });

            $('#createTaskButton').on('click', function() {
                const userPromptText = $('#userPrompt').val();
                const userPromptElement = $(
                    '<h4 class="mb-3 text-white" style=""></h4>').text(
                    userPromptText);

                $('#data_container').empty().append(userPromptElement);

                const responseContainer = $('#response_container');
                // $('#data_container')
                let orderedList = $(
                    '<ol style="background: lightgray;padding: 27px;border-radius: 10px;max-height: 276px;overflow-y: auto;"></ol>'
                );

                $.each(tasks, function(index, task) {
                    let item = $('<li class="mb-2"></li>').html(
                        ` <strong>${task.task}</strong>: ${task.description}`);
                    orderedList.append(item);
                });

                $('#data_container').append(orderedList);
                $('#data_container').append(
                    `<div class="row mt-3 mb-4 "> <div class="col text-center"><button class="btn " data-plan="${userPromptText}" id="save_tasks_btn" style="background: #5ce1e6 !important;border-radius:21px;height:35px; color:white;">Save Plan</button></div>  </div>`
                    );
            });



            $(document).on('click', '#save_tasks_btn', function(e) {
                e.preventDefault();

                // console.log();
                const data = {
                    plan: $(this).data('plan'),
                    tasksList: tasks,
                    user: '{{ Auth::id() }}'
                };
                console.log($(this).data('plan'));
                $.ajax({
                    url: "{{ route('create_tasks') }}", // Replace with your API URL
                    method: "POST",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    success: function(data) {
                        if (data.success) {
                            window.location = '{{ route('show.plans') }}';

                        }
                        // console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            })

            $(document).on('click', '#save_plan_btn', function(e) {
                e.preventDefault();

                const data = {
                    plan: $(this).data('plan'),
                    tasksList: tasks,
                    user: '{{ Auth::id() }}'
                };
                console.log(data);
                $.ajax({
                    url: "{{ route('create_plan') }}", // Replace with your API URL
                    method: "POST",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    success: function(data) {
                        window.location = '{{ route('show.plans') }}';
                        // console.log(data);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", error);
                    }
                });
            })
        });
    </script>
@endsection
