@extends('backoffice._layout.main',['data_table' => true])

@push('title',$title.' Detail')

@push('included-styles')
@endpush

@push('css')
<link href="{{asset('assets/plugins/dropzone/css/dropzone.css')}}" rel="stylesheet" type="text/css" />
<style>
    .form-group label:not(.error) {
        text-transform: none;
    }
    .radio-label{
        margin-bottom: 0px!important;
        margin-left: 10px;
        color: #000001;
    }
    .form-horizontal .form-group .control-label{
        opacity: 1!important;
        color: #000001;
    }
    .form-group .help {
        color: #000001;
    }
    .error-input{
        border-color: #f55753;
    }
    .plr-5{
        padding-left: 5px;
        padding-right: 5px;
    }
    .g-form{
        width: 100%;
    }
    .form-control[readonly]{
        color: #000;
    }
</style>
@endpush

@push('content')
<div class="content sm-gutter">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('backoffice.index')}}">Home</a></li>
            <li class="breadcrumb-item active">{{Str::title($title)}} Detail</li>
        </ol>
        <form action="" name="quizForm" method="post" autocomplete="on" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="row">
                <div class="col-md-5">
                    @include('backoffice.pages.quiz._components.form')
                </div>
                <div class="col-md-7">
                    @include('backoffice.pages.quiz._components.questions')
                </div>
            </div>
        </form>
    </div>
    <!-- END CONTAINER FLUID -->
</div>
@endpush

@push('included-js')
<script src="{{asset('assets/plugins/bootstrap-form-wizard/js/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('assets/js/form_wizard.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('assets/plugins/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('assets/js/form_elements.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/form_layouts.js')}}" type="text/javascript"></script>
@endpush

@push('js')
<script type="text/javascript">
    $(function() {
        let childCounter;
        $(".page-load").hide();

        function submitform()
        {
            document.quizForm.submit();
        }

        $(".btn-remove-question").on( "click", function() {
            let num = $(this).data('num');
            $('.question-'+num+'-div').fadeOut();
            $('.question-'+num+'-div').remove();
        });
        
        $(".btn-add-question").on( "click", function() {
            const ele = document.getElementById('questions-div');
            let divNum = ele.childElementCount+1;
            
            const newDiv = document.createElement('div');
            newDiv.classList.add('question-'+divNum+'-div');
            
            newDiv.innerHTML =  
            `
            <div class="card card-transparent m-b-15" >
                <div class="card-body no-padding">
                    <div id="card-advance" class="card card-default m-b-0">
                        <div class="card-body">
                            <div class="row clearfix">
                                <div class="col-xl-9">
                                    <div class="form-group form-group-default required">
                                        <label for="">Question</label>
                                        <input type="text" class="form-control" name="question[${divNum}]" value="What is the name of the young girl who is the main character?" required>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group form-group-default required">
                                        <label for="">Answer</label>
                                        <input type="text" class="form-control" name="answer[${divNum}]" value="Dorothy" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-check">
                                <div class="row clearfix option-div-edit">
                                    <div class="col-xl-12">
                                        <div class="form-group form-group-default required">
                                            <label for="">A)</label>
                                            <input type="text" class="form-control" name="options[${divNum}][]" placeholder="Option A" value="Lucy" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check">
                                <div class="row clearfix option-div-edit">
                                    <div class="col-xl-12">
                                        <div class="form-group form-group-default required">
                                            <label for="">B)</label>
                                            <input type="text" class="form-control" name="options[${divNum}][]" placeholder="Option B" value="Dorothy" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check">
                                <div class="row clearfix option-div-edit">
                                    <div class="col-xl-12">
                                        <div class="form-group form-group-default required">
                                            <label for="">C)</label>
                                            <input type="text" class="form-control" name="options[${divNum}][]" placeholder="Option C" value="Alice" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check">
                                <div class="row clearfix option-div-edit">
                                    <div class="col-xl-12">
                                        <div class="form-group form-group-default required">
                                            <label for="">D)</label>
                                            <input type="text" class="form-control" name="options[${divNum}][]" placeholder="Option D" value="Wendy" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button title="Remove Question" class="text-danger btn-link btn-remove-question" data-num="${divNum}" type="button"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            `;
            ele.appendChild(newDiv);

            $(".btn-remove-question").on( "click", function() {
                let num = $(this).data('num');
                $('.question-'+num+'-div').fadeOut();
                $('.question-'+num+'-div').remove();
            });
        });

        $(".patch-quiz").on("change keyup keydown", function(){
            let id = $(".input-id").val();
            let title = $(".input-title").val();
            let tl = $(".input-tl").val();
            let nof = $(".input-nof").val();
            let diff = $(".input-diff").val();

            $.ajax({
                type: "POST",
                url: "{{route('backoffice.quiz.patch')}}",
                data: { _id : id , 
                        _title: title, 
                        _tl: tl, 
                        _nof: nof, 
                        _diff: diff, 
                        _token : "{{csrf_token()}}" },
                    dataType: "json",
                async: true,
                success: function(data){
                    // const {
                    //     id,
                    //     title,
                    // } = data.datas;
                    // console.log(data);
                },
                error: function(error){
                    console.log(error);
                }
            });
        });

        $(".btn-generate-questions").on("click", function(){
            $(".page-load").show();

            const questionDiv = document.getElementById("questions-div");
            questionDiv.innerHTML = '';

            let id = $(".input-id").val();
            let nof = $(".input-nof").val();
            let diff = $(".input-diff").val();
            let type = $(this).data('type');
            let request = {
                id: id,
                nof: nof,
                diff: diff
            };

            let context;
            let url;
            console.log(type);
            if(type == "text"){
                context = $("#quiz-context").val();
                url = "{{route('backoffice.quiz.generate', ['type' => 'context'])}}";

            }else if(type == "url"){
                context = $("#quiz-url").val();
                url = "{{route('backoffice.quiz.generate', ['type' => 'url'])}}";

            }else if(type == "upload"){
                submitform();
            }
            // console.log(request);
            // console.log('CONTEXT ==>>'+ context);
            // console.log('URL ==>>'+ url);
            generateQuestions(request, context, url);
        })

        function generateQuestions(request, context, _url){
            $.ajax({
                url: _url,
                method: "POST",
                data: { _id : request.id , 
                        _context: context, 
                        _nof: request.nof, 
                        _diff: request.diff,
                        _token : "{{csrf_token()}}" },
                dataType: "json",
                async: true,
                success: function(data){
                    $(".page-load").hide();
                    console.log(data);
                    console.log(JSON.parse(data.quiz.choices[0].message.content).questions);
                    let questions = JSON.parse(data.quiz.choices[0].message.content).questions;

                    $.each(questions, function( key, value ) {
                        console.log(value);
                        const ele = document.getElementById('questions-div');
                        
                        const newDiv = document.createElement('div');
                        newDiv.classList.add('question-'+key+'-div');
                        
                        console.log("DIFFICULTY ==>> "+request.diff);
                        console.log("CONTEXT ==>> "+context);

                        if(request.diff == 'multiple_choice'){
                            newDiv.innerHTML =  
                            `
                            <div class="card card-transparent m-b-15" >
                                <div class="card-body no-padding">
                                    <div id="card-advance" class="card card-default m-b-0">
                                        <div class="card-body">
                                            <div class="row clearfix">
                                                <div class="col-md-9">
                                                    <div class="form-group form-group-default required">
                                                        <label for="">Question</label>
                                                        <input type="text" class="form-control" name="question[${key}]" value="${value.question}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group form-group-default required">
                                                        <label for="">Answer</label>
                                                        <input type="text" class="form-control" name="answer[${key}]" value="${value.answer}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-check">
                                                <div class="row clearfix option-div-edit">
                                                    <div class="col-xl-12">
                                                        <div class="form-group form-group-default required">
                                                            <label for="">A)</label>
                                                            <input type="text" class="form-control" name="options[${key}][]" placeholder="Option A" value="${value.options[0]}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <div class="row clearfix option-div-edit">
                                                    <div class="col-xl-12">
                                                        <div class="form-group form-group-default required">
                                                            <label for="">B)</label>
                                                            <input type="text" class="form-control" name="options[${key}][]" placeholder="Option B" value="${value.options[1]}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <div class="row clearfix option-div-edit">
                                                    <div class="col-xl-12">
                                                        <div class="form-group form-group-default required">
                                                            <label for="">C)</label>
                                                            <input type="text" class="form-control" name="options[${key}][]" placeholder="Option C" value="${value.options[2]}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <div class="row clearfix option-div-edit">
                                                    <div class="col-xl-12">
                                                        <div class="form-group form-group-default required">
                                                            <label for="">D)</label>
                                                            <input type="text" class="form-control" name="options[${key}][]" placeholder="Option D" value="${value.options[3]}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button title="Remove Question" class="text-danger btn-link btn-remove-question" data-num="${key}" type="button"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        }else if(request.diff == 'true_false'){
                            newDiv.innerHTML =  
                            `
                            <div class="card card-transparent m-b-15" >
                                <div class="card-body no-padding">
                                    <div id="card-advance" class="card card-default m-b-0">
                                        <div class="card-body">
                                            <div class="row clearfix">
                                                <div class="col-md-9">
                                                    <div class="form-group form-group-default required">
                                                        <label for="">Question</label>
                                                        <input type="text" class="form-control" name="question[${key}]" value="${value.question}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group form-group-default required">
                                                        <label for="">Answer</label>
                                                        <input type="text" class="form-control" name="answer[${key}]" value="${value.answer}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-check">
                                                <div class="row clearfix option-div-edit">
                                                    <div class="col-xl-12">
                                                        <div class="form-group form-group-default required">
                                                            <label for="">A)</label>
                                                            <input type="text" class="form-control" name="options[${key}][]" placeholder="Option A" value="${value.options[0]}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <div class="row clearfix option-div-edit">
                                                    <div class="col-xl-12">
                                                        <div class="form-group form-group-default required">
                                                            <label for="">B)</label>
                                                            <input type="text" class="form-control" name="options[${key}][]" placeholder="Option B" value="${value.options[1]}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button title="Remove Question" class="text-danger btn-link btn-remove-question" data-num="${key}" type="button"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        }else if(request.diff == 'identification'){
                            newDiv.innerHTML =  
                            `
                            <div class="card card-transparent m-b-15" >
                                <div class="card-body no-padding">
                                    <div id="card-advance" class="card card-default m-b-0">
                                        <div class="card-body">
                                            <div class="row clearfix">
                                                <div class="col-md-9">
                                                    <div class="form-group form-group-default required">
                                                        <label for="">Question</label>
                                                        <input type="text" class="form-control" name="question[${key}]" value="${value.question}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group form-group-default required">
                                                        <label for="">Answer</label>
                                                        <input type="text" class="form-control" name="answer[${key}]" value="${value.answer}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button title="Remove Question" class="text-danger btn-link btn-remove-question" data-num="${key}" type="button"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;
                        }
                        
                        ele.appendChild(newDiv);

                        $(".btn-remove-question").on( "click", function() {
                            let num = $(this).data('num');
                            $('.question-'+num+'-div').fadeOut();
                            $('.question-'+num+'-div').remove();
                        });
                    });
                    submitform();
                },
                error: function(error){
                    console.log(error);
                }
            });
        }
    });
</script>
@endpush