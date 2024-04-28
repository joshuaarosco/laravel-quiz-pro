@extends('backoffice._layout.main',['data_table' => true])

@push('title',$title.' List')

@push('included-styles')
@endpush

@push('css')
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
                    <div class="pull-right table-btn">
                        {{-- <button class="btn btn-default btn-xs md-hidden mr-1">
                            <i class="fa fa-filter"></i> Filter
                        </button> --}}
                    </div>
                </div>
                <div class="col-md-2 sm-hidden">
                </div>
                <div class="col-md-3 sm-hidden">
                    <form action="" method="get">
                        <input type="text" class="frm-control w-100 pull-right" name="search" value="{{ Input::has('search')?Input::get('search'):'' }}" placeholder="Filter by Name or Department and hit enter...">
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
                        <td class="v-align-middle bold" width="15%">Avatar</td>
                        <td class="v-align-middle bold" width="15%">Name</td>
                        <td class="v-align-middle bold" width="20%">Email</td>
                        <td class="v-align-middle bold" width="20%">Department</td>
                        <td class="v-align-middle bold text-right" width="15%">Actions</td>
                    </tr>
                    @forelse($professors as $index => $info)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td class="v-align-middle semi-bold">
                            <span class="thumbnail-wrapper circular inline avatar">
                                @if($info->getAvatar()!='/')
                                <img src="{{asset($info->getAvatar())}}" alt="avatar" height="40" width="40">
                                @else
                                <img src="{{asset('assets/img/profiles/avatar.jpg')}}" alt="avatar" height="40" width="40">
                                @endif
                            </span>
                        </td>
                        <td class="v-align-middle">{{$info->fname}} {{$info->mname}} {{$info->lname}}</td>
                        <td class="v-align-middle">
                            <a href="mailto:{{$info->email}}">{{$info->user->email}}</a>
                        </td>
                        <td> {{Str::limit($info->department,50)}} </td>
                        <td class="text-right">
                            <button
                            class="btn btn-default btn-rounded btn-xs btn-view"
                            title="Edit" data-id="{{$info->id}}"
                            data-toggle="modal"
                            data-target="#view">
                                <i class="fa fa-eye"></i>
                            </button>
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
                @if($professors->count() > 0)
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

@push('modal-create')
<form method="POST" action="" id="form-personal" role="form" autocomplete="off">
    @csrf
    @include('backoffice.pages.professors._components.form')
    <div class="clearfix"></div>
    <button class="btn btn-success mr-2" type="submit">Create a new {{Str::lower($title)}}</button>
    <button class="btn btn-warning" data-dismiss="modal">Close</button>
</form>
@endpush

@push('modal-edit')
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

@push('css')
<style>
    .avatar{
        height: 70px;
        width: 70px;
    }
</style>
@endpush

