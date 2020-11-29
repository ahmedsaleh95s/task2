@extends('app')

@section('content')
    {{$dataTable->table()}}
@endsection

@push('scripts')
    {{$dataTable->scripts()}}
    <script>
        $(document).on('click', '.btn', function (e) {
            var btn = $(this);
            var WEEKDAYS = ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            var from = $(this).parent().parent().children().eq(0).text();
            var to = $(this).parent().parent().children().eq(1).text();
            var day = $(this).parent().parent().children().eq(2).text();
            var today = new Date();
            var currentDay = today.getDay();
            var distance = WEEKDAYS.indexOf(day) - currentDay;
            today.setDate(today.getDate() + distance);
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();
            var dateFrom = yyyy+ '-' + mm + '-' + dd + ' ' + from;
            var dateTo = yyyy+ '-' + mm + '-' + dd + ' ' + to;
            console.log(dateFrom);
            console.log(dateTo);
                e.preventDefault();
                $.ajax({
                    type: "POST",
                url: "/api/users/reservation/"+ $(this).attr('id'),
                data: {
                    'from' : dateFrom,
                    'to' : dateTo,
                },
                headers : {
                        'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('tokenUser'))
                    },
                    success: function (data) {
                        btn.prop( "disabled", true );
                    },
                })
        });
    </script>
@endpush