export const userCreate = () => {
    const isAdminCheckbox = document.querySelector('#is_admin');
    const alertBox = document.querySelector('#is_admin_alert');

    isAdminCheckbox.addEventListener('change', (event) => {
        const { target: { checked } } = event;

        alertBox.setAttribute('aria-disabled', (!checked).toString());

        if (checked) {
            alertBox.classList.remove('d-none');
            return;
        }

        alertBox.classList.add('d-none');
    });
}
