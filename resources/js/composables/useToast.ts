import Swal from 'sweetalert2';

export const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end', // or 'center'
    iconColor: 'white',
    customClass: {
        popup: 'colored-toast', // You can style in CSS
    },
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});
