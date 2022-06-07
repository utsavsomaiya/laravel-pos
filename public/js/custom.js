function deleteConfirm(type,id) {
    alertify.confirm('Delete  ' + type, 'Are you sure you want to delete this ' + type + '?', function () {
        document.getElementById("delete-"+ type +"-" + id).submit();
    }, function () {
        return;
    });
}
