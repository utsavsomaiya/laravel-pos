function deleteConfirm(type,id) {
    alertify.confirm('Delete  '+ type, 'Are you sure to delete this ' + type + '?', function () {
        document.getElementById("delete-"+ type +"-" + id).submit();
    }, function () {
        return;
    });
}
