let all = [];
$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/api/users",
        headers : {
            'Authorization': 'Bearer ' + JSON.parse(localStorage.getItem('token'))
          },
        dataType: 'json',
        success: function (data) {
            all = data;
            console.log(data.data[0].image.image);
            for (let index = 0; index < data.data.length; index++) {
                $('.table-add').append(
                    '<tr>' +
                    '<th scope="col">#' + data.data[index]['id'] + '</th>' +
                    '<td scope="col">' + data.data[index]['name'] + '</td>' +
                    '<td scope="col">' + data.data[index]['email'] + '</td>' +
                    '<td scope="col">' + data.data[index]['phone'] + '</td>' +
                    '<th scope="col"><img class="rounded-circle img-size" src="' + data.data[index].image.image + '"/></th>' +
                    '</tr>');
            }
        }
    });

    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".table-add tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
});