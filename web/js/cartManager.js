var x = $(document);
x.ready(start);

function start() {
    $(".actions").on("click", ".btn_refresh", function () {
        console.log('go');
        var id = $(this).attr('id_product');

        var quantity = $(this).parent().parent().find("#quantity").find(".quantity_product").val()
        update_cart(id, quantity);
        //   var link_post = $(this).attr('href');
        //var title_post = $(this).attr('the_title');

        //  delete_post(link_post, title_post);
    });
    $(".actions").on("click", ".btn_delete", function () {
        console.log('go');
        var id = $(this).attr('id_product');

        var quantity = $(this).parent().parent().find("#quantity").find(".quantity_product").val()
        delete_cart(id, quantity);
        //   var link_post = $(this).attr('href');
        //var title_post = $(this).attr('the_title');

        //  delete_post(link_post, title_post);
    });

}

function update_cart(id, quantity) {

    $.ajax({

        url: "/updateCart",
        data: {
            id: id,
            quantity: quantity
        },
        cache: false,
        error: function (data) {
            alert("error");
        },
        success: function (data) {
            console.log(data);
            location.reload();
        }
    });
}


function delete_cart(id, quantity) {

    $.ajax({

        url: "/deleteCart",
        data: {
            id: id,
            quantity: quantity
        },
        cache: false,
        error: function (data) {
            alert("error");
        },
        success: function (data) {
            console.log(data);
            location.reload();
        }
    });
}