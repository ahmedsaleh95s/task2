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
              // laravel data table 
                $('.table-add').append(
                    '<tr>' +
                    '<th scope="col">#' + data.data[index]['id'] + '</th>' +
                    '<td scope="col">' + data.data[index]['name'] + '</td>' +
                    '<td scope="col">' + data.data[index]['email'] + '</td>' +
                    '<td scope="col">' + data.data[index]['phone'] + '</td>' +
                    '<th scope="col"><img class="rounded-circle img-size" src="' + data.data[index].image.image + '"/></th>' +
                    '</tr>');
            }
        },
        error: function (xhr) {
          var errors = xhr.responseJSON.errors;
          if (xhr.status == 401) {
            window.location.replace("/admin/login");
          }
      }
    });

    $("#searchName").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".table-add tr").filter(function() {
          $(this).toggle($(this).find('td').eq(0).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $("#searchEmail").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".table-add tr").filter(function() {
          $(this).toggle($(this).find('td').eq(1).text().toLowerCase().indexOf(value) > -1)
        });
      });

      $("#searchPhone").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".table-add tr").filter(function() {
          $(this).toggle($(this).find('td').eq(2).text().toLowerCase().indexOf(value) > -1)
        });
      });
});