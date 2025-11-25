document.addEventListener('DOMContentLoaded', () => {
    const dropdown = document.querySelectorAll('.admin__dashboard__list > li');
    const originalActive = document.querySelector('.admin__dashboard__list > li.active');
    const adminDashboard = document.querySelector('.admin__dashboard__profile');

    const modalElements = {
        userModal: document.querySelector('.admin__actions__modal'),
        addUserModal: document.querySelector('#addUserModal'),
    };

    const forms = {
        addUserForm: document.getElementById('addUser'),
        modalBody: document.getElementById('admin__actions__modal__body'),
    };

    const buttons = {
        newUser: document.getElementById('newUser'),
        closeUserModal: document.querySelector('.admin__actions__modal .close-btn'),
        closeAddUserModal: document.getElementById('closeAddUserModal'),
    };

    const rows = document.querySelectorAll('.admin__content__table .admin__content__tr');
    const select = document.getElementById('actionSelect');
    const defaultMessage = "Are you sure you want to perform this action?";
    const actionMessage = document.getElementById('actionMessage');
    const actionButton = document.querySelector('#handleUserAction button.admin__button');
    const userId = document.querySelector('.modal__content__head #userId');
    /**
     * Open a modal by removing the `hidden` class.
     */
    function openModal(modal) {
        modal.classList.remove('hidden');
        if (select.querySelector('option[value=default]')) {
            select.querySelector('option[value=default]').selected = true;
        }
        if (modal.querySelector('#default')) {
            modal.querySelector('#default').classList.remove('hidden');
        }
    }

    /**
     * Close a modal by adding the `hidden` class.
     */
    function closeModal(modal) {
        modal.classList.add('hidden');
        resetForms(modal);
    }

    /**
     * Reset forms inside a modal by hiding form containers and resetting inputs.
     */
    function resetForms(modal) {
        modal.querySelectorAll('.modal__form__container').forEach(form => form.classList.add('hidden'));
    }

    /**
     * Load user data into the modal fields.
     */
    function loadUserData(row) {
        const id = row.querySelector('td:nth-child(1)').textContent.trim().replace('#', '');
        const username = row.querySelector('td:nth-child(2)').textContent.trim();
        const email = row.querySelector('td:nth-child(3)').textContent.trim();

        document.querySelectorAll('input#userId').forEach(input => input.value = id);
        document.querySelectorAll('input#username').forEach(input => input.value = username);
        document.querySelectorAll('input#email').forEach(input => input.value = email);
    }

    /**
     * Show the form corresponding to the selected action.
     */
    function switchForm(action) {
        resetForms(modalElements.userModal);
        const targetForm = document.getElementById(action);
        if (targetForm) {
            targetForm.classList.remove('hidden');
        }
    }

    /**
     * Update the action message based on user action.
     */
    function updateActionMessage(selectedAction) {
        switch (selectedAction) {
            case 'deactivate':
                actionMessage.textContent = "Are you sure you want to deactivate this user?";
                actionButton.textContent = "Yes, deactivate.";
                break;
            case 'reactivate':
                actionMessage.textContent = "Are you sure you want to reactivate this user?";
                actionButton.textContent = "Yes, reactivate.";
                break;
            case 'delete':
                actionMessage.textContent = "Are you sure you want to delete this user? This action cannot be undone.";
                actionButton.textContent = "Yes, delete.";
                break;
            default:
                actionMessage.textContent = defaultMessage;
        }
    }

    /**
     * Generic function to submit a form via AJAX.
     */
    async function submitForm(endpoint, formData, successCallback) {
        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: { 'X-Requested-With': 'ajax' },
                body: formData,
            });
            const result = await response.json();
            if (result.success) {
                displayAlert(result.success, result.message).then(successCallback);
            } else {
                displayAlert(false, result.message);
            }
        } catch (error) {
            console.error('Error submitting form:', error);
            displayAlert(false, 'An error occurred. Please try again.');
        }
    }

    if (modalElements.userModal && modalElements.addUserModal) {
        // Event: Open Add User Modal
        buttons.newUser.addEventListener('click', () => {
            openModal(modalElements.addUserModal);
        });

        // Event: Close Add User Modal
        buttons.closeAddUserModal.addEventListener('click', () => {
            closeModal(modalElements.addUserModal);
        });

        // Event: Close User Modal
        buttons.closeUserModal.addEventListener('click', () => {
            closeModal(modalElements.userModal);
        });

        // Event: Open User Modal with loaded data
        rows.forEach(row => {
            row.addEventListener('click', () => {
                openModal(modalElements.userModal);
                loadUserData(row);
            });
        });

        // Event: Handle form visibility based on action selection
        select.addEventListener('change', (event) => {
            const selectedAction = event.target.value;
            switchForm(selectedAction);
        });

        // Event: Update action message for specific user actions
        const userActionSelect = document.querySelector('#handleUserAction select#action');
        userActionSelect.addEventListener('change', (event) => {
            const selectedAction = event.target.value;
            updateActionMessage(selectedAction);
        });

        // Event: Close modal by clicking outside content
        document.addEventListener('click', (e) => {
            if (
                e.target === modalElements.userModal ||
                e.target === modalElements.addUserModal
            ) {
                closeModal(e.target);
            }
        });

        // Event: Submit Add User Form
        forms.addUserForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(forms.addUserForm);
            submitForm('/admin/addUser', formData, () => {
                closeModal(modalElements.addUserModal);
                location.reload();
            });
        });

        // Event: Handle User Action Modal
        forms.modalBody.addEventListener('submit', (event) => {
            event.preventDefault();
            const formData = new FormData(event.target);
            const action = select.value;
            formData.append('actionSelect', action);
            formData.append('userId', userId.value);

            submitForm(`/admin/${action}`, formData, () => {
                closeModal(modalElements.userModal);
                location.reload();
            });
        });

        // Event: Close modals on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal(modalElements.userModal);
                closeModal(modalElements.addUserModal);
            }
        });
    }

    navbarHover(dropdown, originalActive);

    adminDashboard.addEventListener('click', e => {
        const list = document.querySelector('.admin__dashboard__list');
        if (list.style.display === 'none' || !list.style.display) {
            list.style.display = 'block';
        } else {
            list.style.display = 'none';
        }
    })
});