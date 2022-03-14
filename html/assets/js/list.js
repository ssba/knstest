var totalItems = 0;
var Items = [];
var currentPage = 1;
var pageSize = 5;

var URL = "http://site1.opencart";

var sessionCookie = $.cookie('session');
if(sessionCookie){
    SetSession(sessionCookie);
}

var session = GetSession();
if(session){
    localStorage.removeItem('session');
}else{
    window.location.replace("/");
}


$(document).ready(function () {
    GetData(currentPage,pageSize);
});

$(document).on("click", "a.page", function(e){
    currentPage = $(this).data( "page" );
    GetData(currentPage,pageSize);
});

$(document).on("click", "a#prev", function(e){
    currentPage = currentPage - 1;
    GetData(currentPage,pageSize);
});

$(document).on("click", "a#next", function(e){
    currentPage = currentPage + 1;
    GetData(currentPage,pageSize);
});

$(document).on("click", ".btn-logout", function(e){
    logout();
});

function GetData(page, count) {
    var data = {
        page: page,
        count: count,
    };



    $.ajax({
        type: "GET",
        url: URL + "/users",
        headers:{
            'Authorization': "Bearer " + session
        },
        beforeSend: function (xhr) {
            xhr.setRequestHeader('Authorization', "Bearer " + session);
        },
        data: data,
        dataType: "json",
        encode: true,
    }).done(function (data) {
        totalItems = data.total;
        Items = data.response;

        paginate(totalItems);
        $("#userlistTable").empty();
        for(var j = 0; j < Items.length; j++){
            var row = Items[j];
            var line =
            "        <tr  class=\"list-group-item\">\n" +
            "          <td><div class=\"item-detail-ok\"><img class=\"item-img\" src=\"assets/ok.svg\" alt=\"done\"></div></td>\n" +
            "          <td style=\"width: 80%;\">\n" +
            "            <div class=\"item-detail\">\n" +
            "              <span>\n" +
            "                <p class=\"item-info\">"+ row.username +"</p>\n" +
            "                <p class=\"user-fullname\">"+ row.Name +"</p>\n" +
            "              </span>\n" +
            "            </div>\n" +
            "          </td>\n" +
            "          <td>\n" +
            "            <span>\n" +
            "              <p class=\"item-info\">...</p>\n" +
            "              <p class=\"item-info\">Default Group</p>\n" +
            "            </span>\n" +
            "          </td>\n" +
            "        </tr>";

            $("#userlistTable").append(line);
        }
    }).fail(function (data) {
        window.location.replace("/");
    });
}

function paginate(totalItems) {
    let totalPages = Math.ceil(totalItems / pageSize);
    $("#pagination").empty();

    if (currentPage < 1) {
        currentPage = 1;
    } else if (currentPage > totalPages) {
        currentPage = totalPages;
    }

    if(currentPage > 1){
        $("#pagination").append('<a id="prev" href="#">Prev</a>');
    }

    for(var i = 0; i < totalPages; i++){
        var page = i + 1;
        if(page === currentPage){
            $("#pagination").append('<a class="page active" data-page="'+ page +'" href="#">'+ page +'</a>');
        }else{
            $("#pagination").append('<a class="page " data-page="'+ page +'" href="#">'+ page +'</a>');
        }
    }

    if(currentPage < totalPages){
        $("#pagination").append('<a id="next" href="#">Next</a>');
    }
}

function logout() {
    $.ajax({
        type: "DELETE",
        url: URL + "/auth",
        dataType: "json",
        encode: true,
    }).done(function (data) {
        $.removeCookie('session');
        window.location.replace("/");
    }).fail(function (data) {
        console.log(data);
    });

}

function GetSession() {
    return localStorage.getItem('session');
}

function SetSession(token) {
    localStorage.setItem('session', token);
}
