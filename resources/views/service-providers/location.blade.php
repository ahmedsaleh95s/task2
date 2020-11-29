@extends('app')

@section('content')
        <table class="table table-bordered" id="users-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>EMAIL</th>
                    <th>NAME_AR</th>
                    <th>NAME_EN</th>
                    <th>PHONE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Id</th>
                    <th>NAME_AR</th>
                    <th>NAME_EN</th>
                    <th>PHONE</th>
                    <th>EMAIL</th>
                </tr>
            </tfoot>
        </table>
@endsection

@push('scripts')
    <script>
        let lat , long;
        function showPosition(position) {
            lat = position.coords.latitude;
            long = window.long = position.coords.longitude;
            $(function() {
                $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        // '/api/users/service-provider/distance?lat=40.74894149554&long=-73.98615270853'
                        url: '/service-provider/distance?lat=' + lat +'&long=' + long,
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'email',
                            name: 'email',
                            render:function(data, type, row){
                                return "<a href='/service-provider/"+ row.id +"'>" + row.email + "</a>";
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
                        $('.btn').click(function (e) { 
                        e.preventDefault();
                        $.ajax({
                            type: "POST",
                        url: "/api/users/reservation/"+ $(this).attr('id'),
                        data: {
                            'from' : $('.from').val(),
                            'to' : $('.to').val(),
                        },
                        headers : {
                                'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('tokenUser'))
                            },
                        })
                    });
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

    </script>
        @endpush
