@extends('app')

@section('content')
<div class="row" style="margin-left: 30%;">
<div class="col-2 float-right">
    <label class="form-check-label">
        <input type="checkbox" id="1" name="id" class="form-check-input check">
        ID
      </label>
</div>

<div class="col-2">
    <label class="form-check-label">
        <input type="checkbox" id="2" name="name" class="form-check-input check">
        NAME
      </label>
</div>
  
<div class="col-2">
    <label class="form-check-label">
        <input type="checkbox" id="3" name="email" class="form-check-input check">
        EMAIL
      </label>
</div>
  
  <div class="col-2">
    <label class="form-check-label">
        <input type="checkbox" id="4" name="phone" class="form-check-input">
        PHONE
      </label>
  </div>
</div>

    {{$dataTable->table()}}
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
    <script>
        $(document).ready(function() {
            var columns = [];
            $(".check").click(function(event){
                if ($(this).is(":checked")) {
                    alert()
                    columns.push(parseInt($(this).attr('id')));
                }else{
                    console.log(parseInt($(this).attr('id')));
                    columns.splice(parseInt($(this).attr('id')) - 1, 1); 
                }
                console.log(columns);
            });
            var table = $('#users-table').DataTable();
                $('input[type="search"').on( 'keyup change', function () {
                    console.log(columns);
                    table.columns(columns).search( this.value )
                    .draw();
                });
        });
    </script>
@endpush