<!-- home.blade.php -->
@extends('adminlte::page')
@section('title', 'Acquaint - Mails')
@section('content')
<style>
    .error{
        color:red;
    }
</style>
<div class="box">
	<div class="box-header">
		<div class="btn-group pull-right">
			<a href="{{route('admin.inbox.create')}}" class="btn btn-primary pull-right" style="margin-right:10px;">
			<i class="fa fa-fw fa-envelope "></i>
				<span class="text">Compose</span>
			</a>
		</div>
            

	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<table id="carsdaTatable" class="table table-bordered table-striped">
			<thead>
				<tr>
                                    <th style="width:10%">No</th>
					<th>Subject</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>
</div>
@endsection

@section('js')
<script>
		$(document).ready(function () {
                   
         
			 $.ajaxSetup({
			  headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			  }
			});
               $('#carsdaTatable').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{ url('/admin/inbox') }}',
               columns: [
					 {data: 'DT_RowIndex', name: 'DT_RowIndex'},
					{data: 'subject', name: 'name'},
					{data: 'action', name: 'action'},
				],
				"aoColumnDefs": [
					{ "bSortable": false, "aTargets": [ 0, 2 ] },
					{ "bSearchable": false, "aTargets": [ 0, 2 ] }
				]
            });
            $(document).on("click","#read-mail",function() {
				var id = $(this).attr('data-id');
				var status = $(this).attr('data-status');
								
				$.ajax({
					url: "{{ route('admin.inbox.read') }}",
					type: 'POST',
					data:{
						_token : '{{ csrf_token() }}',
						id : id,
						status:status
					},
					success: function(result){
                                            $('#carsdaTatable').DataTable().ajax.reload();
						 Swal.fire(
						'Good job!',
						result.message,
						'success'
						);
					}
				});
			});
		
         });
         </script>
@stop