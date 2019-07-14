var x = $(document);
x.ready(start);

function start() {
    $(".actions").on("click", ".btn_refresh", function () {

        var id = $(this).attr('id_product');
        var quantity = $(this).parent().parent().find("#quantity").find(".quantity_product").val()
        update_cart(id, quantity);
    });
    $(".actions").on("click", ".btn_delete", function () {
        var id = $(this).attr('id_product');

        var quantity = $(this).parent().parent().find("#quantity").find(".quantity_product").val()
        delete_cart(id, quantity);
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

            location.reload();
        }
    });
}