document.addEventListener( 'DOMContentLoaded', () => {
    const dropdown = document.querySelectorAll( '.account__dashboard__list > li' );
    const originalActive = document.querySelector('.account__dashboard__list > li.active');
    const accountDashboard = document.querySelector('.account__dashboard__profile')

    const editButtons = document.querySelectorAll('.account__button');
    const forms = document.querySelectorAll('.form__popup');
    const formsWrapper = document.querySelector('.forms');
    const closeButtons = document.querySelectorAll('.form__popup__head > .close-btn');

    navbarHover(dropdown, originalActive);

    if (accountDashboard) {
        accountDashboard.addEventListener('click', e => {
            const list = document.querySelector('.account__dashboard__list');
            if (list.style.display === 'none' || !list.style.display) {
                list.style.display = 'block';
            } else {
                list.style.display = 'none';
            }
        })
    }

    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            closeAllForms();

            const targetFormId = button.id.replace('edit', 'change');
            const targetFormContainer = document.getElementById(targetFormId);

            if (targetFormContainer) {
                formsWrapper.classList.remove('hidden');
                targetFormContainer.classList.remove('hidden');

                const formElement = targetFormContainer.querySelector('form');

                if (button.classList.contains('sell')) {
                    const nftName = button.getAttribute('data-nft-name');
                    const nftId = button.getAttribute('data-nft-id');
                    targetFormContainer.querySelector('.form__popup__head h2').textContent = `Do you really want to sell ${nftName}?`;
                    formElement.querySelector('input').value = nftId;
                }

                formElement.querySelectorAll('input').forEach(input => {
                    if (input.id.startsWith('confirm')) {
                        const originalFieldId = input.id.replace('confirm', '').toLowerCase();
                        const originalField = formElement.querySelector(`#${originalFieldId}`);
                        const submitButton = formElement.querySelector('button[type=submit]');

                        if (originalField) {
                            input.addEventListener('input', () => {
                                if (input.value === originalField.value) {
                                    input.setCustomValidity('');
                                    submitButton.disabled = false;
                                } else {
                                    input.setCustomValidity('Fields do not match.');
                                    submitButton.disabled = true;
                                }
                                input.reportValidity();
                            });
                        }
                    }
                });

                if (!formElement.hasAttribute('data-listener-added')) {
                    formElement.addEventListener('submit', async (event) => {
                        event.preventDefault();

                        const formData = new FormData(formElement);
                        await fetch(`/account/${targetFormId}`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'ajax'
                            },
                            body: formData,
                        })
                            .then(response => response.json())
                            .then(result => {
                                console.log(result)
                                if (result.success) {
                                    closeAllForms();
                                    displayAlert(result.success, result.message)
                                        .then(() => {
                                            location.reload();
                                        })
                                }
                                else {
                                    displayAlert(result.success, result.message);
                                }
                            });
                        formElement.setAttribute('data-listener-added', 'true');
                    });
                }
            }
        });
    });

    closeButtons.forEach( button => {
        button.addEventListener('click', () => {
            closeAllForms();
        })
    })

    if (formsWrapper) {
        formsWrapper.addEventListener('click', e => {
            if (e.target === formsWrapper) {
                closeAllForms();
            }
        })
    }

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeAllForms();
        }
    })

    function closeAllForms() {
        formsWrapper.classList.add('hidden');
        forms.forEach( form => form.classList.add('hidden'));
    }
})

