function confirmDelete(url, name) {
    Swal.fire({
        title: 'Xác nhận xóa ' + name + '?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa'
    }).then((result) => {
        if (result.isConfirmed) {
            // Nếu người dùng xác nhận, chuyển hướng đến URL để xóa
            window.location.href = url;
        }
    });
}