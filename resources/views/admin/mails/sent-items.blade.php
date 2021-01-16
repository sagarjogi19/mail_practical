<!-- home.blade.php -->
@extends('adminlte::page')
@section('title', 'Acquaint - Sent Mails')
@section('content')
<style>
    .error{
        color:red;
    }
</style>
<div class="box">
	<!-- /.box-header -->
	<div class="box-body">
		<table id="carsdaTatable" class="table table-bordered table-striped">
			<thead>
				<tr>
                                    <th>No</th>
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
               ajax: '{{ url('/admin/sent-items') }}',
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
		
         });
         </script>
@stop