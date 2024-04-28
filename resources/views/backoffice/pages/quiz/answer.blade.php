@extends('backoffice._layout.main',['data_table' => true])

@push('title',$title.' Response')

@push('included-styles')
@endpush

@push('css')
<link href="{{asset('assets/plugins/dropzone/css/dropzone.css')}}" rel="stylesheet" type="text/css" />
<style>
    .form-group label:not(.error) {
        text-transform: none;
    }
    .radio-label{
        margin-bottom: 0px!important;
        margin-left: 10px;
        color: #000001;
    }
    .form-horizontal .form-group .control-label{
        opacity: 1!important;
        color: #000001;
    }
    .form-group .help {
        color: #000001;
    }
    .error-input{
        border-color: #f55753;
    }
    .plr-5{
        padding-left: 5px;
        padding-right: 5px;
    }
    .g-form{
        width: 100%;
    }
    .clock{
        border: 1px dashed black;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        padding: 30px;
        padding-top: 60px;
    }
</style>
@endpush

@push('content')
<div class="content sm-gutter">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('backoffice.index')}}">Home</a></li>
            <li class="breadcrumb-item active">Answer {{Str::title($title)}}</li>
        </ol>
        <form action="" method="post" autocomplete="on">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="row">
                <div class="col-md-7">
                    <div class="card card-transparent">
                        <div class="card-body no-padding">
                            <div id="card-advance" class="card card-default">
                                <div class="card-body">
                                    <h4> What is the name of the young girl who is the main character?</h4>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" name="texture" id="defaultradio" value="Default" checked="">
                                        <label for="defaultradio">
                                        A) Lucy
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="texture" id="radio1" value="Medium">
                                        <label for="radio1">
                                        B) Dorothy
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="texture" id="radio2" value="Verbose">
                                        <label for="radio2">
                                        C) Alice
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="texture" id="radio2" value="Verbose">
                                        <label for="radio2">
                                        D) Wendy
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-transparent">
                        <div class="card-body no-padding">
                            <div id="card-advance" class="card card-default">
                                <div class="card-body">
                                    <h4> What natural disaster struck Dorothy's home?</h4>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" name="texture2" id="defaultradio" value="Default" checked="">
                                        <label for="defaultradio">
                                        A) Hurricane
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="texture2" id="radio1" value="Medium">
                                        <label for="radio1">
                                        B) Cyclone
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="texture2" id="radio2" value="Verbose">
                                        <label for="radio2">
                                        C) Earthquake
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="texture2" id="radio2" value="Verbose">
                                        <label for="radio2">
                                        D) Tornado
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-transparent">
                        <div class="card-body no-padding">
                            <div id="card-advance" class="card card-default">
                                <div class="card-body">
                                    <h4> Who did Dorothy's falling house kill?</h4>
                                    <br>
                                    <div class="form-check">
                                        <input type="radio" name="texture3" id="defaultradio" value="Default" checked="">
                                        <label for="defaultradio">
                                        A) The Wicked Witch of the West
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="texture3" id="radio1" value="Medium">
                                        <label for="radio1">
                                        B) The Wicked Witch of the East
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="texture3" id="radio2" value="Verbose">
                                        <label for="radio2">
                                        C) The Good Witch of the North
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" name="texture3" id="radio2" value="Verbose">
                                        <label for="radio2">
                                        D) The Wizard of Oz
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                                        
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="mw-80">Quiz Title</h5>
                            <h2 class="mw-80">Wizard of Oz</h2>
                            <div class="row clearfix m-t-50">
                                <div class="col-xl-4">
                                </div>
                                <div class="col-xl-4">
                                    <div class="clock">
                                        <h1>03:29</h1>
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                </div>
                            </div>
                            <div class="text-center m-b-50">
                                <h6>Time Remaining</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- END CONTAINER FLUID -->
</div>
@endpush

@push('included-js')
<script src="{{asset('assets/plugins/bootstrap-form-wizard/js/jquery.bootstrap.wizard.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
<script src="{{asset('assets/js/form_wizard.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('assets/plugins/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('assets/js/form_elements.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/form_layouts.js')}}" type="text/javascript"></script>
@endpush

@push('js')<script type="text/javascript">
    $(function() {
        $(".page-load").hide();
        
        'use strict';
        
        const path = require('path');
        const google = require('@googleapis/forms');
        const {authenticate} = require('@google-cloud/local-auth');
        
        const formID = '1Jr_AUCTggp5AgUp4DAGdX6kDDtlh0t4NhUC4WN4S9WU';
            
            async function runSample(query) {
                const auth = await authenticate({
                    keyfilePath: path.join(__dirname, 'credentials.json'),
                    scopes: 'https://www.googleapis.com/auth/forms.body.readonly',
                });
                const forms = google.forms({
                    version: 'v1',
                    auth: auth,
                });
                const res = await forms.forms.get({formId: formID});
                console.log(res.data);
                return res.data;
            }
            
            if (module === require.main) {
                runSample().catch(console.error);
            }
            module.exports = runSample;
        });
    </script>
@endpush