@extends('admin.layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Email Template</h3>
    </div>
    <div class="card-body collapse in">
        <div class="card-block">
            <form role="form" method="POST" action="{{ route('admin.emailtemplate.update',$EmailTemplate->id) }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group{{ $errors->has('template_name') ? ' has-error' : '' }}">
                    <label for="template_name">Template Name</label>

                    <input id="template_name" type="text" class="form-control" name="template_name" value="{{ old('template_name',$EmailTemplate->template_name) }}" required autofocus>

                    @if ($errors->has('template_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('template_name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('sender_name') ? ' has-error' : '' }}">
                    <label for="sender_name">Sender Name</label>

                    <input id="sender_name" type="text" class="form-control" name="sender_name" value="{{ old('sender_name', $EmailTemplate->sender_name) }}" required >

                    @if ($errors->has('sender_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('sender_name') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('sender_email') ? ' has-error' : '' }}">
                    <label for="sender_email">Sender Email</label>

                    <input id="sender_email" type="text" class="form-control" name="sender_email" value="{{ old('sender_email', $EmailTemplate->sender_email) }}" required >

                    @if ($errors->has('sender_email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('sender_email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email_subject') ? ' has-error' : '' }}">
                    <label for="email_subject">Email Subject</label>

                    <input id="email_subject" type="text" class="form-control" name="email_subject" value="{{ old('email_subject', $EmailTemplate->email_subject) }}" required >

                    @if ($errors->has('email_subject'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email_subject') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                    <label for="content">Email Content</label>

                    <textarea name="content" id="myeditor" required>{{ old('content', $EmailTemplate->content) }}</textarea>

                    @if ($errors->has('content'))
                    <span class="help-block">
                        <strong>{{ $errors->first('content') }}</strong>
                    </span>
                    @endif
                </div>
                 <div class="col-xs-12 mb-2">
                    <a href="{{ route('admin.emailtemplate.index') }}" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check-square-o"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/admin/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('assets/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $('.datepicker').datepicker();
</script>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('myeditor');
</script>
@endsection
