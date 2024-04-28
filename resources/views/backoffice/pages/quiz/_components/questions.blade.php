<!-- <button class="btn btn-default btn-block btn-lg btn-add-question m-b-15" type="button"> + Add Question </button> -->
<div id="questions-div">
    @foreach($quiz->questions as $index => $question)
    <div class="question-{{ $index }}-div">
        <div class="card card-transparent m-b-15" >
            <div class="card-body no-padding">
                <div id="card-advance" class="card card-default m-b-0">
                    <div class="card-body">
                        <div class="row clearfix">
                            <div class="col-md-9">
                                <div class="form-group form-group-default required">
                                    <label for="">Question {{$index+=1}}</label>
                                    <input type="text" class="form-control" name="question[{{ $index }}]" value="{{ $question->question }}" {{ $quiz->status =='publish'?'readonly':'' }} required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-group-default required">
                                    <label for="">Answer</label>
                                    <input type="text" class="form-control" name="answer[{{ $index }}]" value="{{ $question->answer }}" {{ $quiz->status =='publish'?'readonly':'' }} required>
                                </div>
                            </div>
                        </div>
                        @if($quiz->difficulty != 'identification')
                        <br>
                        @endif
                        @php
                        $x = 0;
                        @endphp
                        @foreach($question->options as $i => $option)
                        <div class="form-check">
                            <div class="row clearfix option-div-edit">
                                <div class="col-xl-12">
                                    <div class="form-group form-group-default required">
                                        <label for="">{{ $letters[$x] }}</label>
                                        <input type="text" class="form-control" name="options[{{ $index }}][]" placeholder="Option A" value="{{ $option->option }}" {{ $quiz->status =='publish'?'readonly':'' }} required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                        $x += 1;
                        @endphp
                        @endforeach
                    </div>
                    @if($quiz->status != 'publish')
                    <div class="card-footer">
                        <button title="Remove Question" class="text-danger btn-link btn-remove-question" data-num="{{ $index }}" type="button"><i class="fa fa-times"></i></button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>