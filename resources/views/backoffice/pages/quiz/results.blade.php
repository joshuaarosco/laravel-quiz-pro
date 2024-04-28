@extends('backoffice._layout.main',['data_table' => true])

@push('title','Quiz Results')

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
            <li class="breadcrumb-item active">{{Str::title($title)}} Results</li>
        </ol>
        <div class="p-3 bg-white b-1">
            <div class="row">
                <div class="col-md-7 col-xs-6">
                    <a class="m-r-15" href="{{ route('backoffice.quiz.view', $quiz->id) }}"><i class="fa fa-chevron-left"></i> &nbsp; BACK</a> QUIZ RESULTS: <strong>{{ $quiz->title }}</strong>
                </div>
                <div class="col-md-5 sm-hidden">
                    <form action="" method="get">
                        <input type="text" class="frm-control w-100 pull-right" name="search" value="{{ Input::has('search')?Input::get('search'):'' }}" 
                        placeholder="Filter by Name, Course, Section or School Year and hit enter...">
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-hover table-condensed" id="condensedTable">
                <tbody>
                    <tr>
                        <td class="v-align-middle bold" width="5%">#</td>
                        <td class="v-align-middle bold" width="25%">Name</td>
                        <td class="v-align-middle bold" width="15%">Status</td>
                        <td class="v-align-middle bold" width="25%">Score</td>
                        <td class="v-align-middle bold" width="20%">Course</td>
                        <td class="v-align-middle bold" width="15%">Section</td>
                        <td class="v-align-middle bold" width="15%">School Year</td>
                        <td class="v-align-middle bold text-right" width="15%">Actions</td>
                    </tr>
                    @forelse($students as $index => $info)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td class="v-align-middle">{{ $info->lname }}, {{ $info->fname }}</td>
                        <td class="v-align-middle">{{ Str::upper(str_replace('_',' ',$results[$info->user->id]->status))?:'---' }}</td>
                        <td class="v-align-middle">{{ $results[$info->user->id]->scoreResult() }}/{{ $quiz->questions->count() }}</td>
                        <td>{{$info->course}}</td>
                        <td>{{$info->section}}</td>
                        <td>{{$info->school_year}} </td>
                        <td class="text-right">
                            @if(auth()->user()->type == 'student' OR $results[$info->user->id]->status == 'completed')
                            <a
                                class="btn btn-default btn-rounded btn-md btn-edit"
                                title="Answer" href="{{route('backoffice.quiz.answer',['id' => $results[$info->user->id]->id])}}">
                                <i class="fa fa-file-text-o"></i> &nbsp; {{ $info->status == 'pending'?'Take Quiz':'View Result' }}
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            No {{Str::lower(Str::plural($title))}} data yet...
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($students->count() > 0)
                <tfoot>
                    <tr>
                        <th colspan="8">
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
    $(".btn-delete").on("click",function(){
        $(".continue-delete").attr("href",$(this).data('url'));
    });
    $(".page-load").hide();
});
</script>
@endpush


