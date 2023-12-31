@extends('layouts.backend.main')

@section('title')
    Create - Plan
@endsection

@section('admin-content')
    <div class="container  ">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" style="background-color:lightblue">
                    <div class="card-body">
                        <div class="card bg-transparent">
                            <div class="card-body">
                                <form id="prompt_submit">
                                    <div class="form-group">
                                        <label for="userPrompt">Enter User Prompt:</label>
                                        <textarea class="form-control" id="userPrompt" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                        <div class="card mt-4 bg-transparent">
                            <div class="card-body">
                                <h5 class="card-title">Text Display Area</h5>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" id="display_response" readonly>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eu tortor lacus.</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {

            $('#userPrompt').on('input', function(e) {
                e.preventDefault();

                $('#display_response').val($(this).val());
            })

            $('#prompt_submit').submit(function(e){
                e.preventDefault();

                const data = {
                    prompt:$(this).find('#userPrompt').val(),
                }
                fetch('http://localhost/chatbot_openai/public/prompt/search/test',
                {
                    method:'POST',
                    body:JSON.stringify(data),
                    headers:{
                        'Content-Type': 'application/json',
                    }
                }).then(function(response){
                    return response.json();
                }).then(function(result){
                    console.log(result.content.replace(/\\n\\n|\r\r|\\ /g, ''));

                });
            })
        });
    </script>
@endsection
