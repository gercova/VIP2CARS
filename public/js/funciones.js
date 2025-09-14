$(document).ready(function(){
    $('.exit-system').on('click', async function(e){
        e.preventDefault();
        try {
            const result = await swal.fire({
                title: '¿Quieres salir del sistema?',
                text: '¿Estás seguro que quieres cerrar la sesión?',
                type: 'warning',   
                showCancelButton: true,   
                confirmButtonColor: "#16a085",   
                confirmButtonText: "Si, salir",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                animation: "slide-from-top"
            });
            if (result.isConfirmed) {
                const response = await axios.post(`${API_BASE_URL}/logout`);
                if(response.status == 200 && response.data.status == true){
                    window.location.href = response.data.redirect;
                }  
            }
        } catch (error) {
            console.error('Error al cerrar la sesión:', error);   
        }
    });
});

function alertNotify(icon, message){
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })  
    Toast.fire({
        icon: icon,
        //title: 'Operación realizada',
        //html: messages,
        title: message,
    })
}