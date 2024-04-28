
<div class="card">
    <div class="card-body">
        <h2 class="mw-80">Quiz Detail</h2>
        <p class="fs-16 mw-80 m-b-20"> Create your first quiz or test with AI, by entering some content below.</p>
        <input type="hidden" class="input-id" name="id" value="{{ $quiz->id }}">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-default required">
                    <label>Quiz Title</label>
                    <input type="text" class="form-control patch-quiz input-title" name="title" value="{{ old('title', $quiz->title) }}" {{ $quiz->status == 'publish'?'readonly':'' }}>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="form-group form-group-default required">
                    <label>Time Limit (minutes)</label>
                    <input type="number" class="form-control patch-quiz input-tl" name="time_limit" value="{{ old('time_limit', $quiz->time_limit) }}" {{ $quiz->status == 'publish'?'readonly':'' }}>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-default required">
                    <label>No of Questions</label>
                    <input type="number" max="25" min="1" class="form-control patch-quiz input-nof" name="no_of_questions" value="{{ old('no_of_questions', $quiz->no_of_questions) }}" {{ $quiz->status == 'publish'?'readonly':'' }}>
                </div>
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="form-group form-group-default required">
                    <label>Difficulty</label>
                    <select name="difficulty" class="form-control patch-quiz input-diff" id="" {{ $quiz->status == 'publish'?'readonly disabled':'' }}>
                        @foreach(__('difficulty') as $index => $diff)
                        @if($index == $quiz->difficulty)
                        <option value="{{ $index }}" selected>{{$diff}}</option>
                        @else
                        <option value="{{ $index }}">{{$diff}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
@if($quiz->status != 'publish')
<div class="card">
    <div class="card-body">
        <h4 class="mw-80">Generate questions with our AI powered by GPT-4</h4>
        <p class="fs-16 mw-80 m-b-20"> You can generate questions by pasting text context, url of an article or upload a PDF file.</p>
        <div class="card card-borderless">
            <ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">
            <li class="nav-item">
                <a class="active" data-toggle="tab" role="tab" data-target="#text" href="#">Text</a>
            </li>
            <li class="nav-item">
                <a href="#" data-toggle="tab" role="tab" data-target="#url">URL</a>
            </li>
            <li class="nav-item">
                <a href="#" data-toggle="tab" role="tab" data-target="#uploads">PDF</a>
            </li>
            <!-- <li class="nav-item">
                <a href="#" data-toggle="tab" role="tab" data-target="#manual">Manual</a>
            </li> -->
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="text">
                    @include('backoffice.pages.quiz._components.text')
                </div>
                <div class="tab-pane " id="url">
                    @include('backoffice.pages.quiz._components.url')
                </div>
                <div class="tab-pane" id="uploads">
                    @include('backoffice.pages.quiz._components.uploads')
                </div>
                <div class="tab-pane" id="manual">
                    @include('backoffice.pages.quiz._components.manual')
                </div>
            </div>
            <p class="">
                <i class="text-danger">NOTE: Generating new questions will <strong>replace</strong> the set of questions that has been generated.</i>
            </p>
        </div>
    </div>
</div>
<!-- <div class="col-md-6">
    <button class="btn btn-default btn-block btn-lg" type="submit" value="save">Save</button>
</div> -->
<button class="btn btn-default btn-lg m-b-20 m-r-15" type="submit" name="btn_submit" value="save"><i class="fa fa-save"></i> &nbsp; Save</button>
<button class="btn btn-primary btn-lg m-b-20" type="submit" name="btn_submit" value="publish">Publish Quiz</button>
@else
<a class="btn btn-default btn-lg m-b-20 m-r-15" href="{{ route('backoffice.quiz.index') }}"><i class="fa fa-chevron-left"></i> &nbsp; Back</a>
<a class="btn btn-success btn-lg m-b-20 pull-right" href="{{ route('backoffice.quiz.results', $quiz->id) }}"><i class="fa fa-file-text-o"></i> &nbsp; View Results</a>
<a class="btn btn-primary btn-lg m-b-20 m-r-15 pull-right" href="{{ route('backoffice.quiz.assign', $quiz->id) }}"><i class="fa fa-user-plus"></i> &nbsp; Assign</a>
@endif