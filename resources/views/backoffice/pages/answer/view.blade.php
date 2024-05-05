@extends('backoffice._layout.main',['data_table' => true])

@push('title',$title.' Response')

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
    .fs-17{
        font-size: 17px!important;
    }
    .my-answer{
        color: #ce4e4d;
        font-weight: bold;
    }
    .correct-answer{
        color: #19ad79!important;
        font-weight: bold;
    }
    .clock {
        width: 250px;
        height: 250px;
        padding-bottom:50%;
        border-radius:50%;
        border: 1px dashed black;
        margin: 0 auto;
        padding: 10px;
        position: relative;
    }
    .clock h1{
        position:absolute;
        top:50%; left:50%;
        transform: translate(-50%, -50%);
        margin:0;
    }
    .blur {
        -webkit-filter: blur(5px);
        -moz-filter: blur(5px);
        -o-filter: blur(5px);
        -ms-filter: blur(5px);
        filter: blur(5px);
        background-color: #ccc;
    }
    .score{
        font-size: 100px;
    }
</style>
@endpush

@push('content')
<div class="content sm-gutter">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('backoffice.index')}}">Home</a></li>
            @if(auth()->user()->type == 'student')
            <li class="breadcrumb-item">
                <a href="{{route('backoffice.quiz.pending')}}">Quizzes</a>
            </li>
            @endif
            @if(auth()->user()->type != 'student')
            <li class="breadcrumb-item">
                <a href="{{route('backoffice.quiz.view', $quiz->id)}}">Detail</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('backoffice.quiz.results', $quiz->id)}}">Results</a>
            </li>
            @endif
            <li class="breadcrumb-item active">Quiz : {{Str::title($quiz->title)}}</li>
        </ol>
        <form name="quizForm" action="" method="POST">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            @if(auth()->user()->type != 'student')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-transparent m-b-15 {{ $result->status == 'pending'?'blur':'' }}">
                        <div class="card-body no-padding">
                            <div id="card-advance" class="card card-default m-b-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <h5>Student: <strong>{{ $result->user->student->lname }}, {{ $result->user->student->fname }}</strong></h5>
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Section: <strong>{{ $result->user->student->section }}</strong></h5>
                                        </div>
                                        <div class="col-md-4">
                                            <h5>Course: <strong>{{ $result->user->student->course }}</strong></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    @include('backoffice.pages.answer._components.questions')
                </div>
                <div class="col-md-4">
                    @include('backoffice.pages.answer._components.timer')

                    @if($result->status == 'on_going')
                    <button type="submit" class="btn btn-success btn-lg btn-block">Submit Answer</button>
                    @endif

                    @if($result->status == 'pending')
                    <input type="submit" name="quiz_btn" class="btn btn-warning btn-lg btn-block" value="Start Answering">
                    @endif

                    @if(auth()->user()->type != 'student')
                    <a class="btn btn-default btn-lg" href="{{route('backoffice.quiz.results', $quiz->id)}}"><i class="fa fa-chevron-left"></i> &nbsp; Back to Quiz Results</a>
                    @endif
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
        $(".page-load").hide();

        function submitform(){
            document.quizForm.submit();
        }

        function countdown( elementName, minutes, seconds ){
            var element, endTime, hours, mins, msLeft, time;

            function twoDigits( n ){
                return (n <= 9 ? "0" + n : n);
            }

            function updateTimer(){
                msLeft = endTime - (+new Date);
                if ( msLeft < 1000 ) {
                    element.innerHTML = "Time is up!";
                    setTimeout( submitform(), 5000 );
                } else {
                    time = new Date( msLeft );
                    hours = time.getUTCHours();
                    mins = time.getUTCMinutes();
                    element.innerHTML = (hours ? hours + ':' + twoDigits( mins ) : mins) + ':' + twoDigits( time.getUTCSeconds() );
                    setTimeout( updateTimer, time.getUTCMilliseconds() + 500 );

                    updateClock( twoDigits( mins ) , twoDigits( time.getUTCSeconds() ));
                }
            }

            element = document.getElementById( elementName );
            endTime = (+new Date) + 1000 * (60*minutes + seconds) + 500;
            updateTimer();
        }
        @if($result->status == 'on_going')
        //countdown( "countdown", {!! sprintf('%02s', $result->minute) !!}, {!! sprintf('%02s', $result->seconds) !!} );
        @endif

        function updateClock(mins, secs){
            $.ajax({
                url: "{{ route('backoffice.quiz.update_clock', $result->id) }}",
                method: "POST",
                data: { _mins: mins , 
                        _secs: secs, 
                        _token : "{{csrf_token()}}" },
                dataType: "json",
                async: true,
                success: function(data){
                    console.log(data);
                },
                error: function(error){
                    console.log(error);
                }
            });
        }
    });
</script>

@endpush