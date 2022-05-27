function deleteConfirm(type) {
    if (type == "categories") {
        alertify.confirm('Delete Category', 'Are you sure to delete this category?', function () {
            document.getElementById("delete-category").submit();
        }, function () {
            return;
        });
    }
    if (type == 'products') {
        alertify.confirm('Delete Product', 'Are you sure to delete this product?', function () {
            document.getElementById("delete-product").submit();
        }, function () {
            return;
        });
    }
    if (type == 'discounts') {
        alertify.confirm('Delete Discount', 'Are you sure to delete this Discount?', function () {
            document.getElementById("delete-discount").submit();
        }, function () {
            return;
        });
    }
}
