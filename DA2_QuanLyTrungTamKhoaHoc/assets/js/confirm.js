function confirmXacNhan(url, name) {
    Swal.fire({
        title: 'Xác nhận đăng ký của học viên ' + name + '?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xác Nhận'
    }).then((result) => {
        if (result.isConfirmed) {
            // Nếu người dùng xác nhận, chuyển hướng đến URL để xóa
            window.location.href = url;
        }
    });
}