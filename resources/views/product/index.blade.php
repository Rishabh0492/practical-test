@extends('layouts.item')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header"> Product List </div>
                @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-Success') }}">{{ Session::get('message') }}</p>
@endif


                <div class="card-body">
                	<a href="/all-products/create" class="btn btn-success btn-sm">Add Product</a><br><br>
                   <table id="productDataTable" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
  <thead class="thead-light">
    <tr>
    	<th class="th-sm">#ID

      </th>		
      <th class="th-sm">Product Name

      </th>
      <th class="th-sm">Quantity

      </th>
      <th class="th-sm">Manufacture Date

      </th>
      <th class="th-sm">Created Date

      </th>
      <th class="th-sm">Action

    </tr>
  </thead>
</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
        $('#productDataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "/getItemData",
                     "dataType": "json",
                     "type": "post",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" ,sortable:true},
                { "data": "name",sortable:true },
                { "data": "quantity",sortable:true },
                { "data": "manufacture_date",sortable:true},
                { "data": "created_at",sortable:true},
                {
                bSortable: false,
                "render": function ( data, type, row ) {
                    return '<a href="/all-products/'+row.id+'/edit" class="btn btn-primary btn-sm">Edit</a> <a href="/all-products/delete/'+row.id+'" class="btn btn-danger btn-sm">Delete</a>';
                },
            },

            ]    

        });
});		
</script>