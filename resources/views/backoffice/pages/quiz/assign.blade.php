@extends('backoffice._layout.main',['data_table' => true])

@push('title','Assign Students')

@push('included-styles')
@endpush

@push('css')
<style>
    .avatar{
        height: 70px;
        width: 70px;
    }
</style>
@endpush

@push('content')
<div class="content sm-gutter">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('backoffice.index')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('backoffice.quiz.view', $quiz->id)}}">Detail</a></li>
            <li class="breadcrumb-item active">Student List</li>
        </ol>
        <div class="p-3 bg-white b-1">
            <div class="row">
                <div class="col-md-7 col-xs-6">
                    <a class="m-r-15" href="{{ route('backoffice.quiz.view', $quiz->id) }}"><i class="fa fa-chevron-left"></i> &nbsp; BACK</a> | QUIZ: <strong>{{ $quiz->title }}</strong>
                </div>
                <div class="col-md-4 sm-hidden">
                    <form action="" method="get">
                        <input type="text" class="frm-control w-100 pull-right" name="search" value="{{ Input::has('search')?Input::get('search'):'' }}" placeholder="Filter by Last Name, ID Number, Course or Section and hit enter...">
                    </form>
                </div>
                @if(auth()->user()->type == 'professor')
                <div class="col-md-1 sm-hidden">
                    <button type="submit" class="btn btn-success btn-xs btn-block table-btn assign-btn"><i class="fa fa-check"></i>&nbsp; ASSIGN</button>
                </div>
                @endif
            </div>
        </div>
        <hr>
        <form name="assignForm" action="" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" value="{{$quiz->id}}" name="quiz_id">
        <div class="table-responsive">
            <table class="table table-hover table-condensed" id="condensedTable">
                <tbody>
                    <tr>
                        <td class="v-align-middle bold" width="3%">#</td>
                        <td class="v-align-middle bold" width="3%"><input type="checkbox" name="select_all" id="" class="select-all"></td>
                        <td class="v-align-middle bold" width="20%">Name</td>
                        <td class="v-align-middle bold" width="15%">ID Number</td>
                        <td class="v-align-middle bold" width="20%">Course</td>
                        <td class="v-align-middle bold" width="10%">Section</td>
                    </tr>
                    @forelse($students as $index => $info)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td class="v-align-middle">
                            <input type="checkbox" name="user_id[]" class="select" value="{{$info->user->id}}" {{ $info->user->result($quiz->id)?'checked':'' }}>
                        </td>
                        <td class="v-align-middle">{{ $info->lname }}, {{ $info->fname }}</td>
                        <td class="v-align-middle">{{ $info->id_number }}</td>
                        <td class="v-align-middle">{{ $info->course }}</td>
                        <td class="v-align-middle">{{ $info->section }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No student data yet...
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($students->count() > 0)
                <tfoot>
                    <tr>
                        <th colspan="6">
                            <div class="row">
                                <div class="col-md-12">

                                </div>
                            </div>
                        </th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        </form>
    </div>
</div>
@endpush

@push('modal-view')
@endpush


@push('modal-delete')
<i class="pg pg-trash_line big-icon"></i>
<h5>You are about to <span class="semi-bold text-danger">delete</span> a <span class="semi-bold text-success">{{Str::lower($title)}}</span>, do you want to proceed?</h5>
<br>
<a href="" class="btn btn-success btn-block continue-delete">Continue</a>
<button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cancel</button>
@endpush

@push('included-scripts')
@endpush

@push('js')
<script type="text/javascript">
$(function() {
    $(".select-all").on("change",function(){
        var checked = $(".select-all:checked").length;
    
        if (checked == 0) {
            $(".select").prop('checked', false);
        } else {
            $(".select").prop('checked', true);
        }
    });
    $(".assign-btn").on("click", function(){
        document.assignForm.submit();
    });
    $(".page-load").hide();
});
</script>
@endpush


