@extends('backoffice.auth._layout.main')

@push('content')
<div class="login-wrapper">
    <div class="bg-pic">
        {{-- <img alt="" class="lazy" data-src="{{asset('web/assets/images/PSU_banner.jpg')}}" data-src-retina="{{asset('web/assets/images/PSU_banner.jpg')}}" src="{{asset('web/assets/images/PSU_banner.jpg')}}"> --}}
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
            <h2 class="semi-bold text-white">{{ config('app.name') }} {{ ucfirst($user_type) }} Registration</h2>
            <p class="small"></p>
        </div>
    </div>
    <div class="login-container bg-white" style="overflow-y: scroll;">
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
            <h3>{{ config('app.name') }} <br><strong>{{ ucfirst($user_type == 'professor'?'instructor':$user_type) }}</strong> Registration</h3>
            @if(session()->has('notification-status'))
            <div class="m-t-35 alert alert-{{session()->get('notification-status')}}" role="alert">
                <button class="close" data-dismiss="alert"></button>
                <strong>{{Str::title(session()->get('notification-status'))}}: </strong> {{session()->get('notification-msg')}}
            </div>
            @else
            <!-- <p class="p-t-35">Please make sure to enter the details you provided after the clearance.</p> -->
            @endif
            <form action="" method="POST" class="p-t-15" id="form-login" name="form-login" role="form">
                <input type="hidden" name="user_type" value="{{ $user_type }}">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group form-group-default">
                            <label>First Name <span class="text-danger">*</span></label>
                            <div class="controls">
                                <input class="form-control" name="fname" value="{{ old('fname') }}" placeholder="First Name" required="" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-group-default">
                            <label>Last Name <span class="text-danger">*</span></label>
                            <div class="controls">
                                <input class="form-control" name="lname" value="{{ old('lname') }}" placeholder="Last Name" required="" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                @if($user_type == 'professor')
                <div class="form-group form-group-default">
                    <label>Department <span class="text-danger">*</span></label>
                    <div class="controls">
                        <input class="form-control" name="department" value="{{ old('department') }}" placeholder="Department" required="" type="text">
                    </div>
                </div>
                @else
                <div class="form-group form-group-default {{$errors->has('id_number')?'has-error':null}}">
                    <label>ID Number <span class="text-danger">*</span></label>
                    <div class="controls">
                        <input class="form-control" name="id_number" value="{{ old('id_number') }}"  placeholder="ID Number" required="" type="text">
                    </div>
                </div>
                @if($errors->has('id_number'))
                <label id="field-error" class="error" for="field">{{$errors->first('id_number')}}</label>
                @endif

                <div class="form-group form-group-default">
                    <label>Course <span class="text-danger">*</span></label>
                    <div class="controls">
                        <input class="form-control" name="course" value="{{ old('course') }}" placeholder="Course" required="" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group form-group-default">
                            <label>Section <span class="text-danger">*</span></label>
                            <div class="controls">
                                <input class="form-control" name="section" value="{{ old('section') }}" placeholder="Section" required="" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group form-group-default">
                            <label>School Year <span class="text-danger">*</span></label>
                            <div class="controls">
                                <input class="form-control" name="school_year" value="{{ old('school_year') }}" placeholder="School Year" required="" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="form-group form-group-default {{$errors->has('email')?'has-error':null}}">
                    <label>Email <span class="text-danger">*</span></label>
                    <div class="controls">
                        <input class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required="" type="email">
                    </div>
                </div>
                @if($errors->has('email'))
                <label id="field-error" class="error" for="field">{{$errors->first('email')}}</label>
                @endif

                <div class="form-group form-group-default {{$errors->has('password_confirmation')?'has-error':null}}">
                    <label>Password <span class="text-danger">*</span></label>
                    <div class="controls">
                        <input class="form-control" name="password_confirmation" placeholder="Password" required="" type="password">
                    </div>
                    @if($errors->has('password_confirmation'))
                    <label id="field-error" class="error" for="field">{{$errors->first('password_confirmation')}}</label>
                    @endif
                </div>
                <div class="form-group form-group-default {{$errors->has('password')?'has-error':null}}">
                    <label>Confirm Password <span class="text-danger">*</span></label>
                    <div class="controls">
                        <input class="form-control" name="password" placeholder="Confirm Password" required="" type="password">
                    </div>
                </div>
                @if($errors->has('password'))
                <label id="field-error" class="error" for="field">{{$errors->first('password')}}</label>
                @endif

                <button class="btn btn-success btn-cons m-t-10 m-b-20" type="submit">Register</button>
                <a class="btn btn-default btn-cons m-t-10 m-b-20" href="{{route('backoffice.auth.login')}}">Back to Sign In</a>
            </form>
        </div>
    </div>
</div>
@endpush
