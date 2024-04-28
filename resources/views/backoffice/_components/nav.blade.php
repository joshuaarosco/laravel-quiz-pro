<nav class="page-sidebar" data-pages="sidebar">
	<div class="sidebar-header">
		<label>{{config('app.name')}}</label>
	</div>
	<div class="sidebar-menu">
		<ul class="menu-items">
			<li class="m-t-30 {{in_array(request()->route()->getName(),['backoffice.index'])?'open active':''}}">
				<a class="detailed" href="{{route('backoffice.index')}}">
                    <span class="title">Dashboard</span>
                </a>
                <span class="{{in_array(request()->route()->getName(),['backoffice.index'])?'bg-success':''}} icon-thumbnail">
                    <i class="pg-home"></i>
                </span>
			</li>
            @if(auth()->check() AND (auth()->user()->type == 'super_user' OR auth()->user()->type == 'admin'))
            <li class="{{Request::is('backoffice/instructor*')?'open active':''}}">
                <a href="javascript:;">
                    <span class="title">Instructor</span>
                    <span class="arrow {{Request::is('backoffice/instructor*')?'open active':''}}"></span>
                </a>
                <span class="icon-thumbnail {{Request::is('backoffice/instructor*')?'bg-success':''}}">
                    <i class="fa fa-briefcase"></i>
                </span>
                <ul class="sub-menu">
                    <li class="{{in_array(request()->route()->getName(),['backoffice.instructor.index'])?'open active':''}}">
                        <a href="{{route('backoffice.instructor.index')}}">List</a> <span class="icon-thumbnail">l</span>
                    </li>
                </ul>
            </li>
            <li class="{{Request::is('backoffice/student*')?'open active':''}}">
                <a href="javascript:;">
                    <span class="title">Student</span>
                    <span class="arrow {{Request::is('backoffice/student*')?'open active':''}}"></span>
                </a>
                <span class="icon-thumbnail {{Request::is('backoffice/student*')?'bg-success':''}}">
                    <i class="fa fa-users"></i>
                </span>
                <ul class="sub-menu">
                    <li class="{{in_array(request()->route()->getName(),['backoffice.student.index'])?'open active':''}}">
                        <a href="{{route('backoffice.student.index')}}">List</a> <span class="icon-thumbnail">l</span>
                    </li>
                </ul>
            </li>
            @endif

            <li class="{{Request::is('backoffice/quiz*')?'open active':''}}">
                <a href="javascript:;">
                    <span class="title">Quiz</span>
                    <span class="arrow {{Request::is('backoffice/quiz*')?'open active':''}}"></span>
                </a>
                <span class="icon-thumbnail {{Request::is('backoffice/quiz*')?'bg-success':''}}">
                    <i class="fa fa-book"></i>
                </span>
                <ul class="sub-menu">
                    @if(auth()->check() AND in_array(auth()->user()->type, ['super_user', 'admin']))
                    <li class="{{in_array(request()->route()->getName(),['backoffice.quiz.index'])?'open active':''}}">
                        <a href="{{route('backoffice.quiz.index')}}">List</a> <span class="icon-thumbnail">l</span>
                    </li>
                    @elseif(auth()->check() AND auth()->user()->type == 'professor')
                    <li class="{{in_array(request()->route()->getName(),['backoffice.quiz.index'])?'open active':''}}">
                        <a href="{{route('backoffice.quiz.index')}}">List</a> <span class="icon-thumbnail">l</span>
                    </li>
                    <li class="{{in_array(request()->route()->getName(),['backoffice.quiz.create'])?'open active':''}}">
                        <a href="{{route('backoffice.quiz.create')}}">Create</a> <span class="icon-thumbnail">c</span>
                    </li>
                    @else
                    <li class="{{in_array(request()->route()->getName(),['backoffice.quiz.pending'])?'open active':''}}">
                        <a href="{{route('backoffice.quiz.pending')}}">List</a> <span class="icon-thumbnail">l</span>
                    </li>
                    @endif
                </ul>
            </li>
		</ul>
		<div class="clearfix"></div>
	</div>
</nav>