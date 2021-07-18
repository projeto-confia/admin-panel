export const userEdit = (isAdmin) => {
    const isAdminCheckbox = document.querySelector('#is_admin');
    const alertBox = document.querySelector('#is_admin_alert');

    if (isAdmin) {
        alertBox.setAttribute('aria-disabled', 'false');
        alertBox.classList.remove('d-none');
    }

    isAdminCheckbox.addEventListener('change', (event) => {
        const { target: { checked } } = event;

        alertBox.setAttribute('aria-disabled', !checked);

        if (checked) {
            alertBox.classList.remove('d-none');
            return;
        }

        alertBox.classList.add('d-none');
    });
}
