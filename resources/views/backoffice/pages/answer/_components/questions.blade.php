@foreach($quiz->questions as $index => $question)
<div class="card card-transparent m-b-15 {{ $result->status == 'pending'?'blur':'' }}">
    <div class="card-body no-padding">
        <div id="card-advance" class="card card-default m-b-0">
            <div class="card-body">
                @if($result->status != 'pending')
                <h4>{{$index+=1}}. {{ $question->question }}</h4>
                @else
                <h4>{{$index+=1}}. I know what you are doing. Don't remove the blur.</h4>
                @endif
                <br>
                <input type="hidden" name="question_id[]" value="{{$question->id}}">
                @php

                @endphp
                @foreach($question->options as $op => $option)
                @if($result->status != 'pending')
                <div class="form-check">
                    <input type="radio" 
                        name="answers[{{$question->id}}]" 
                        id="defaultradio_{{$option->id}}_{{$op}}" 
                        value="{{ $option->option }}" 
                        {{ ( $result->status =='completed' AND $myAnswers[$question->id] == $option->option)?'checked':'' }}
                        {{ $result->status == 'completed'?'disabled':''}}>
                    <label for="defaultradio_{{$option->id}}_{{$op}}" class="fs-17 
                    {{ ( $result->status =='completed' AND $correctAnswers[$question->id] == $option->option)?'correct-answer':'' }} 
                    {{ ( $result->status =='completed' AND $myAnswers[$question->id] == $option->option)?'my-answer':'' }}">
                        {{ $letters[$op] }} {{ $option->option }}
                    </label>
                </div>
                @else
                <div class="form-check">
                    <input type="radio">
                    <label for="defaultradio_{{$option->id}}_{{$op}}" class="fs-17">
                    {{ $letters[$op] }} I know what you are doing. Don't remove the blur.
                    </label>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endforeach
