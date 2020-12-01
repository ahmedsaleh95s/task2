@extends('app')

@section('content')
    <div class="row">
        <div class="col-2">
            <button type="submit" id="all" class="btn btn-info">All</button>
        </div>
    </div>
    <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>EMAIL</th>
                <th>NAME_AR</th>
                <th>NAME_EN</th>
                <th>PHONE</th>
            </tr>
        </thead>
    </table>
@endsection

@push('scripts')
    <script>
        let lat, long;

        function showPosition(position) {
            lat = position.coords.latitude;
            long = window.long = position.coords.longitude;
            $(function() {
                $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/service-provider/distance?lat=' + lat + '&long=' + long,
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'email',
                            name: 'email',
                            render: function(data, type, row) {
                                return "<a href='/service-provider/" + row.id + "'>" + row.email +
                                    "</a>";
                            }
                        },
                        {
                            data: 'name_ar',
                            name: 'name_ar'
                        },
                        {
                            data: 'name_en',
                            name: 'name_en'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                    ],
                    initComplete: function() {
                        this.api().columns().every(function() {
                            var column = this;
                            var input = document.createElement("input");
                            $(input).appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    column.search($(this).val(), false, false, true)
                                        .draw();
                                });
                        });
                    },
                });
            });
        }
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }

        $("#all").click(function (e) { 
            e.preventDefault();
            alert();
            window.location.replace('/api/user-service-providers');
        });
    </script>
@endpush
