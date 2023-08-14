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
    <div class="col text-end" style="text-align: end;">
        <a href="{{ route('homepage') }}" class="btn">Back</a>
    </div>
</div>
    <div id="data_container" class="p-3">
        <div class="row " style="margin-top: rem!important;">
            <div class="col">
                <textarea class="form-control textarea" rows="2" id="userPrompt" disabled placeholder="Input 1"
                    style="font-size: small;">i want to create a social media campaign to drive traffic to my website for our new product</textarea>

            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <button type="button" class="w-100 btn "
                    style="">
                    Submit</button>
            </div>
        </div>
        <div class="row" style="margin-top: 6%;">

            <div class="col">
                <div class="response_container p-2 py-3" id="response_container"></div>
                {{-- <textarea class="form-control textarea" placeholder="Input 2" id="display_response" rows="10"></textarea> --}}

            </div>
        </div>
        <div class="row mt-2">
            <div class="col text-center">
                <button type="button" class="btn" id="createPlanButton"
                    style="background: #5ce1e6 !important;border-radius:21px;height:35px; color:white;">Create
                    Plan
                </button>
            </div>
            <div class="col text-center">
                <button type="button" class="btn" id="createTaskButton"
                    style="background: #5ce1e6 !important;border-radius:21px;height:35px; color:white;">Create
                    Task
                </button>

            </div>
        </div>
        <div class="row mt-4">
            <div class="col text-center">
                <p>We need permissions for the service you use <br>
                    <a href="#" class="text-white">learn more</a>
                </p>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {

            // $('#userPrompt').on('input', function(e) {
            //     e.preventDefault();

            //     $('#display_response').val($(this).val());
            // })
            const userPrompt = $('#userPrompt').val();
            console.log(userPrompt);
            const socialMediaCampaignPlan = [{
                    task: "Define Goals and Objectives",
                    description: "Clearly outline the goals of your campaign, such as increasing website traffic, generating leads, or promoting specific content.",
                },
                {
                    task: "Identify Target Audience",
                    description: "Research and define your ideal audience's demographics, interests, and online behavior to tailor your campaign.",
                },
                {
                    task: "Choose Social Media Platforms",
                    description: "Select the most relevant platforms based on your target audience. Consider platforms like Instagram, Facebook, Twitter, LinkedIn, etc.",
                },
                {
                    task: "Content Strategy",
                    description: "Develop a content strategy that includes a mix of engaging content types, such as articles, videos, infographics, and user-generated content.",
                },
                {
                    task: "Content Calendar",
                    description: "Create a content calendar to schedule and organize your posts. Consistency is key to maintaining audience engagement.",
                },
                {
                    task: "Hashtag Strategy",
                    description: "Research and incorporate relevant hashtags to increase the visibility of your posts and reach a wider audience.",
                },
                {
                    task: "Influencer Collaboration",
                    description: "Identify influencers or industry experts who can promote your campaign to their followers, expanding your reach.",
                },
                {
                    task: "Engagement Plan",
                    description: "Outline how you'll engage with your audience through comments, likes, shares, and direct messages to build relationships.",
                },
                {
                    task: "Paid Advertising",
                    description: "Allocate a budget for targeted ads on social media platforms to reach a larger audience and drive traffic.",
                },
                {
                    task: "Analytics and Tracking",
                    description: "Set up tracking tools to monitor the performance of your campaign. Measure metrics like clicks, conversions, and engagement.",
                },
                {
                    task: "User-Generated Content",
                    description: "Encourage your followers to create content related to your campaign, showcasing their experiences and opinions.",
                },
                {
                    task: "Contests and Giveaways",
                    description: "Run contests or giveaways to incentivize engagement and participation, directing participants to your website.",
                },
                {
                    task: "Optimize Landing Pages",
                    description: "Ensure that the landing pages you're driving traffic to are optimized for conversions and provide a seamless user experience.",
                },
                {
                    task: "A/B Testing",
                    description: "Experiment with different content, posting times, and ad formats to refine your strategy based on data-driven insights.",
                },
                {
                    task: "Monitor and Adjust",
                    description: "Regularly review campaign performance and make necessary adjustments to achieve your goals effectively.",
                },
            ];



            const responseContainer = $('#response_container');

            const orderedList = $('<ol></ol>');

            $.each(socialMediaCampaignPlan, function(index, task) {
                const listItem = $('<li class="mb-2"></li>').html(
                    ` <strong>${task.task}</strong>: ${task.description}`);
                orderedList.append(listItem);
            });

            responseContainer.append(orderedList);



            $('#createPlanButton').on('click', function() {
                const userPromptText = $('#userPrompt').val();
                const userPromptElement = $(
                    '<h4 class="mb-3 text-white" style=""></h4>').text(
                    userPromptText);

                $('#data_container').empty().append(userPromptElement);

                const responseContainer = $('#response_container');

                let taskTextareas = '';

                $.each(socialMediaCampaignPlan, function(index, task) {
                    taskTextareas +=
                        `<label><b>${index+1} :</b>${task.task}</label><textarea class="form-control textarea" rows="3" disabled>${task.description}</textarea>`;
                    // taskTextareas.push(taskTextarea);
                });
                taskTextareas +=
                    '<div class="row mt-3 mb-4 "> <div class="col text-center"><a href="{{ route('show.plans') }}" class="btn " id="save_tasks_btn" style="background: #5ce1e6 !important;border-radius:21px;height:35px; color:white;">Save Tasks</a></div>  </div>'
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
                let orderedList = $('<ol style="background: lightgray;padding: 27px;border-radius: 10px;max-height: 276px;overflow-y: auto;"></ol>');

                $.each(socialMediaCampaignPlan, function(index, task) {
                    let item = $('<li class="mb-2"></li>').html(
                    ` <strong>${task.task}</strong>: ${task.description}`);
                    orderedList.append(item);
                });
                $('#data_container').append(orderedList);
            });

            const data = {
                plan: userPrompt,
                tasks: socialMediaCampaignPlan
            };

            // $(document).on('click', '#save_tasks_btn', function(e) {
            //     e.preventDefault();

            //     // $.ajax({
            //     //     url: "{{ route('create_plan') }}", // Replace with your API URL
            //     //     method: "POST",
            //     //     data: JSON.stringify(data),
            //     //     contentType: "application/json",
            //     //     success: function(data) {
            //     //         if (data.success) {
            //     //             alert(data.message);
            //     //         }
            //     //         console.log(data);
            //     //     },
            //     //     error: function(xhr, status, error) {
            //     //         console.error("Error:", error);
            //     //     }
            //     // });
            // })
        });
    </script>
@endsection
