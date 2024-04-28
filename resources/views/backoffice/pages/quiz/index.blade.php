@extends('backoffice._layout.main',['data_table' => true])

@push('title',$title.' List')

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
            <li class="breadcrumb-item active">{{Str::title($title)}} List</li>
        </ol>
        <div class="p-3 bg-white b-1">
            <div class="row">
                <div class="col-md-7 col-xs-6">
                    {{Str::upper($title)}} LIST
                </div>
                <div class="col-md-{{ auth()->user()->type == 'professor'?'3':'5' }} sm-hidden">
                    <form action="" method="get">
                        <input type="text" class="frm-control w-100 pull-right" name="search" value="{{ Input::has('search')?Input::get('search'):'' }}" placeholder="Filter by Title, Type or Difficulty and hit enter...">
                    </form>
                </div>
                @if(auth()->user()->type == 'professor')
                <div class="col-md-2 sm-hidden">
                    <a href="{{ route('backoffice.quiz.create') }}" class="btn btn-success btn-xs btn-block table-btn"><i class="fa fa-plus"></i>&nbsp;CREATE QUIZ</a> 
                </div>
                @endif
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-hover table-condensed" id="condensedTable">
                <tbody>
                    <tr>
                        <td class="v-align-middle bold" width="5%">#</td>
                        <td class="v-align-middle bold" width="25%">Title</td>
                        <td class="v-align-middle bold" width="15%">Status</td>
                        <td class="v-align-middle bold" width="20%">Difficulty</td>
                        <td class="v-align-middle bold" width="10%">Time Limit</td>
                        <td class="v-align-middle bold" width="10%">Created By</td>
                        <td class="v-align-middle bold text-right" width="15%">Actions</td>
                    </tr>
                    @forelse($quizzes as $index => $info)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td class="v-align-middle">{{ $info->title?:'---' }}</td>
                        <td class="v-align-middle">{{ Str::upper($info->status)?:'---' }}</td>
                        <td class="v-align-middle">{{__('difficulty.'.$info->difficulty) }}</td>
                        <td class="v-align-middle">{{ $info->time_limit?$info->time_limit.' minutes':'--' }}</td>
                        <td class="v-align-middle">{{ $info->user->name }}</td>
                        <td class="text-right">
                            @if(auth()->user()->type != 'student' AND $info->status == 'publish')
                            <a class="btn btn-default btn-rounded btn-md"
                                title="Assign" href="{{ route('backoffice.quiz.view', $info->id) }}">
                                View / Assign
                            </a>
                            @endif
                            @if($info->status != 'publish')
                            <a class="btn btn-default btn-rounded btn-xs btn-edit"
                                title="View" href="{{route('backoffice.quiz.view',['id' => $info->id])}}">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <button class="btn btn-warning btn-rounded btn-xs btn-delete"
                            title="Delete"
                            data-url="{{route('backoffice.quiz.delete',$info->id)}}"
                            data-toggle="modal"
                            data-target="#delete">
                                <i class="fa fa-times"></i>
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No {{Str::lower(Str::plural($title))}} data yet...
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($quizzes->count() > 0)
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


