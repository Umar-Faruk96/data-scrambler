document.addEventListener('DOMContentLoaded', function () {
    const deleteBtn = document.querySelectorAll('.delete');
    for (let i = 0; i < deleteBtn.length; i++) {
        deleteBtn[i].addEventListener('click', function (e) {
            if (!confirm('Delete The User. Are You Sure?')) {
                e.preventDefault();
            }
        })
    }
})