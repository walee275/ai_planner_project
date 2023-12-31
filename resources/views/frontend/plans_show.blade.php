@extends('layouts.frontend.main')

@section('title', 'Plans page')

@section('styles')
    <style>
        .tasks-list-container {
            width: 104%;
            height: 271px;
            border: 1px solid #b0d5de;
            border-radius: 12px;
            background: aliceblue;
            max-height: 100%;
            overflow-y: auto;
            margin: auto;
            padding: 5px;
        }

        .tasks_rows {
            cursor: pointer;
        }

        #description {
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

        <div class="col p-5" id="data_container">


            @if (count($plans))
                @foreach ($plans as $plan)
                    <h4 class="text-justify text-white ">{{ $loop->iteration }}-) {{ $plan->title }}</h4>
                    <div class="tasks-list-container mb-3">
                        @if (count($plan->tasks))
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>S R No.</th>
                                        <th>Task</th>
                                        <th>Date Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($plan->tasks as $task)
                                        <tr class="tasks_rows" data-taskTitle="{{ $task->title }}"
                                            data-taskDesc="{{ $task->description }}"
                                            data-clearification="{{ $task->detailed_description }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->created_at->format('Y-m-d,H:i:s') }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        @else
                            {!! $plan->description !!}
                        @endif

                    </div>
                @endforeach
            @else
                <div class="row">
                    <div class="col text-center">
                        <p class="text-white">No Plans Found</p>

                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col " style="">
                    <button class="btn  mt-2 ml-2" id="back_btn">
                        Create New Plan </button>
                </div>
            </div>




        </div>

    </div>

@endsection





@section('scripts')
    <script>
        $(document).ready(function() {
            $('.tasks_rows').click(function(e) {
                // alert($(this).data('tasktitle'));
                const taskTitle = $(this).data('tasktitle');
                const taskDesc = $(this).data('taskdesc');
                const taskClearification = $(this).data('clearification');

                let output = '<div id="single_task_show">';
                let title =
                    `<h4 class="task_title text-white text-center" id="task_title">${taskTitle}</h4>`
                let desc =
                    `<div class="description p-2 py-3 text-justify" id="description">${taskDesc}
                        <div class="clearification text-justify mt-3" id="clearification"><br>${taskClearification}</div></div>`

                let clearification = ``;
                output += title + desc;
                output += ' </div>';

                $('#data_container').find('h4').addClass('d-none');
                $('#data_container').find('.tasks-list-container').addClass('d-none');

                $('#data_container').append(output);
                $('#clearification ul li').each(function() {
                    // Create a new checkbox element.
                    var checkbox = $('<input>').attr('type', 'checkbox');
                    checkbox.addClass('mx-2');
                    // Prepend the checkbox to the current <li> element.
                    $(this).prepend(checkbox);
                });
                $('#back_btn').text('< Back');

            })

            $('#back_btn').on('click', function(e) {
                e.preventDefault();
                var singleTaskShow = $('#data_container').find('#single_task_show');

                if (singleTaskShow.length) {
                    // The #single_task_show element exists in #data_container
                    singleTaskShow.remove();
                    $('#data_container').find('h4').removeClass('d-none');
                    $('#data_container').find('.tasks-list-container').removeClass('d-none');
                    $('#back_btn').text('Create New Plan');

                } else {
                    window.location = '{{ route('create.plan') }}';
                    // The #single_task_show element does not exist in #data_container
                    // Perform other actions if needed
                }

            });
        });
    </script>
@endsection
