@extends('app')

@section('content')
<form action="#" id="form" style="margin: 5% 5%;">
    <div class="form-group row">
        <label for="example-datetime-local-input" class="col-2 col-form-label">Date and time</label>
        <div class="col-4">
          <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
        </div>
      </div>
      <div class="form-group row">
        <label for="example-datetime-local-input" class="col-2 col-form-label">Date and time</label>
        <div class="col-4">
          <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00" id="example-datetime-local-input">
        </div>
      </div>
      <div class="form-group row">
          <div class="col-2"></div>
        <div class="col-10">
            <button type="submit" class="btn btn-info">RESERVE</button>
        </div>
      </div>
</form>
@endsection

@push('scripts')
<script>
    // send request with id of provider and send from - to
    $('#form').submit(function (e) { 
        e.preventDefault();
    var formData = new FormData(document.getElementById("form"));
        console.log();
        $.ajax({
        type: "POST",
        url: "/api/users/reservation/"+ window.location.href.split("/")[5],
        data: formData,
        dataType: 'json',
        success: function (data) {
            window.location.replace("/users/all");
        },
    });
});
</script>
@endpush