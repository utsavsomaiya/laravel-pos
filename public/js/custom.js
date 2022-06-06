function deleteConfirm(type,id) {
    if (type == "categories") {
        alertify.confirm('Delete Category', 'Are you sure to delete this category?', function () {
            document.getElementById("delete-category-"+id).submit();
        }, function () {
            return;
        });
    }
    if (type == 'products') {
        alertify.confirm('Delete Product', 'Are you sure to delete this product?', function () {
            document.getElementById("delete-product-"+id).submit();
        }, function () {
            return;
        });
    }
    if (type == 'discounts') {
        alertify.confirm('Delete Discount', 'Are you sure to delete this Discount?', function () {
            document.getElementById("delete-discount-"+id).submit();
        }, function () {
            return;
        });
    }
}

$(document).ready(function () {
    $('#products,#category,#discount,#sales').DataTable({
        dom:"<'top'<'row'<'col-sm-4 mt-1'l><'col-sm-8 mb-3'f>>>Btp",
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    });
    $('#sales-details').DataTable({
        dom: "<'top'<'row'<'col-sm-4 mt-1'l><'col-sm-8'f>>>t<'row'<'total'><'row'<'col-sm-4 mt-1'><'col-sm-8'p>>>",
        "order": [],
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": ["_all"]
        }]
    });
    if (document.getElementsByClassName('total')[0] != null) {
        totalHTML = [
            '<div class="row">',
            '<div class="col-sm-8"><span class="mt-2 badge bg-danger">Thankyou!!</div>',
            '<div class="mt-2 col-sm-4 mb-3">',
            '<table class="table table-warning mt-2">',
            '<tr>',
            '<td>Subtotal</td>',
            '<td>=</td>',
            '<td>' + subtotal + '</td>',
            '</tr>',
            '<tr>',
            '<td>Discount</td>',
            '<td>=</td>',
            '<td>' + discount + '</td>',
            '</tr>',
            '<tr>',
            '<td>Tax</td>',
            '<td>=</td>',
            '<td>' + tax + '</td>',
            '</tr>',
            '<tr>',
            '<td class="fw-semibold">Total</td>',
            '<td class="fw-semibold">=</td>',
            '<td class="fw-semibold">' + total + '</td>',
            '</tr>',
            '</table>',
            '</div>'
        ].join('\n');
        document.getElementsByClassName('total')[0].innerHTML += totalHTML;
    }
});
