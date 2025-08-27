import './bootstrap';

window.confirmDelete = function (id) {
        Swal.fire({
    title: "Deseja excluir este usuário?",
    text: 'Esta ação não pode ser desfeita.',
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Sim, excluir!",
    cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}