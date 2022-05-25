function deleteConfirm(id,type) {
    if (type == "categories") {
        return alertify.confirm('Delete Category', 'Are you sure to delete this category?', function () {
            window.location.href = "/admin/categories/delete/" + id;
        }, function () {

        });
    }
    if (type == 'products') {
        return alertify.confirm('Delete Product', 'Are you sure to delete this product?', function () {
            window.location.href = "/admin/products/delete/" + id;
        }, function () {

        });
    }
}
