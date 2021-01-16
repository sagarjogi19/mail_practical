@extends('adminlte::page')
@section('title', 'Acquaint - View Mail')

@section('content')
<div class="row">
    <!-- left column -->
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">View Mail</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" name="frmMail" id="frmMail">
                 <div class="box-body">
                     <div class="form-group">
                        <label for="from" class="col-sm-2 control-label">From</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="from" name="from" value="{{ $mails->from->name.' ('.$mails->from->email.')' }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="col-sm-2 control-label">Subject</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="subject" name="subject" value="{{ $mails->subject }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-2 control-label">Message</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="message" cols="4" name="message"  readonly>{{ $mails->message }}</textarea>
                        </div>
                    </div>

                </div>
                
                @if(!$mails->thread->isEmpty())
                    @foreach($mails->thread as $v)
                    <hr>
                 <div class="box-body">
                     <div class="form-group">
                        <label for="from" class="col-sm-2 control-label">From</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="from" name="from" value="{{ $v->from->name.' ('.$v->from->email.')' }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject" class="col-sm-2 control-label">Subject</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="subject" name="subject" value="{{ $v->subject }}" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-2 control-label">Message</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="message" cols="4" name="message"  readonly>{{ $v->message }}</textarea>
                        </div>
                    </div>

                </div>
                    @endforeach
                @endif
                <div class="box-footer">
                    <a href="{{route('admin.inbox.reply',be64($mails->id))}}" class="btn btn-primary submit">Reply</a>
                    <a href="{{route('admin.inbox.index')}}" class="btn btn-info">Back</a>
                </div>
                <hr>
                
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