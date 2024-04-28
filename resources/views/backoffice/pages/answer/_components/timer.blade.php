
<div class="card">
    <div class="card-body text-center">
        <h5 class="mw-80">Quiz Title</h5>
        <h2 class="mw-80"><strong>{{ $quiz->title }}</strong></h2>
        @if($result->status != 'completed')
        <div class="row clearfix m-t-50">
            <div class="col-xl-12">
                <div class="clock">
                    <h1><div id="countdown">{!!$quiz->time_limit!!}:00</div></h1>
                </div>
            </div>
        </div>
        <div class="text-center m-b-50 m-t-30">
            @if($result->status == 'pending')
            <h5>You have <strong>{!!$quiz->time_limit!!}</strong> minutes to answer.</h5>
            @else
            <h5>Timer</h5>
            @endif
        </div>
        @else
        <div class="row clearfix m-t-50">
            <div class="col-xl-12">
                <div class="clock">
                    <h1><span class="score"><strong>{{$result->scoreResult()}}</strong></span>/{{ $quiz->questions->count() }}</h1>
                </div>
            </div>
        </div>
        <div class="text-center m-b-50 m-t-30">
            <h5>{{ auth()->user()->type == 'student'?'You':'Student' }} got <strong>{{$result->scoreResult()}}</strong> correct {{str_plural('answer', $result->scoreResult()) }} out of <strong>{{ $quiz->questions->count() }}</strong> {{str_plural('questions', $quiz->questions->count()) }}.</h5>
        </div>
        @endif
    </div>
</div>