import Swal from 'sweetalert2';
import { router } from '@inertiajs/vue3';

async function deleteBySwal(href: string, name: string) {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    });

    if (result.isConfirmed) {
        Swal.fire({
            title: 'Deleting...',
            text: 'Please wait while we delete.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => Swal.showLoading(),
        });

        router.delete(href, {
            onSuccess: () => {
                Swal.close();
                Swal.fire('Deleted!', `The ${name} has been deleted.`, 'success');
            },
            onError: () => {
                Swal.close();
                Swal.fire('Error!', 'Something went wrong.', 'error');
            },
        });
    }
}

export { deleteBySwal };