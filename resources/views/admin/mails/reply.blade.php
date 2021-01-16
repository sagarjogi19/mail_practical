@extends('adminlte::page')
@section('title', 'Acquaint - Reply Mail')

@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Reply Mail</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" name="frmMail" id="frmMail" method="post" action="{{route('admin.inbox.store')}}">
                {!! csrf_field() !!}
                <div class="box-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                                {{ session()->get('success') }}
                        </div>
                @endif
                @if (!empty($errors->toarray()))
                 <div class="alert alert-danger">
                        <span>{{ $errors->first() }}</span>
                </div>
                @endif
                <input type="hidden" class="form-control" id="parent_id" name="parent_id" value="{{ isset($mails->parent_id)?$mails->parent_id:$mails->id }}">
                    <div class="form-group">
                        <label for="to" class="col-sm-2 control-label">To<span class="required"> * </span></label>
                        <div class="col-sm-4">
                            <select class="form-control" name="to_user_id" id="to_user_id" readonly>
                                <option value="{{$mails->id}}" selected>{{$mails->to->name.' ('.$mails->to->email.')'}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="col-sm-2 control-label">Subject<span class="required"> * </span></label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" value="{{ $mails->subject }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-2 control-label">Message</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="message" cols="4" name="message" placeholder="Message">{{ old('message') }}</textarea>
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary submit">Submit</button>
                    <a href="{{route('admin.inbox.index')}}" class="btn btn-info">Back</a>
                </div>
            </form>
        </div>

        <!-- /.box-body -->

        <!-- /.box-footer -->

    </div>
    <!-- /.box -->
    <!-- general form elements disabled -->

    <!-- /.box -->
</div>

@endsection
@section('css')

@stop
@section('js')

@stop