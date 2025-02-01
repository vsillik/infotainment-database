import './bootstrap';
import 'bootstrap';

const attachSelectButtons = () => {
    const selectAllButtons = document.getElementsByClassName('btn-select-all');
    const deselectAllButtons = document.getElementsByClassName('btn-deselect-all');

    for (const selectButton of selectAllButtons) {
        selectButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();

            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            for (const checkbox of checkboxes) {
                checkbox.checked = true;
            }

            for (const buttonToHide of selectAllButtons) {
                buttonToHide.classList.add('d-none');
            }

            for (const buttonToShow of deselectAllButtons) {
                buttonToShow.classList.remove('d-none');
            }
        });
    }

    for (const deselectButton of deselectAllButtons) {
        deselectButton.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();

            const checkboxes = document.querySelectorAll('input[type="checkbox"]');

            for (const checkbox of checkboxes) {
                checkbox.checked = false;
            }

            for (const buttonToHide of deselectAllButtons) {
                buttonToHide.classList.add('d-none');
            }

            for (const buttonToShow of selectAllButtons) {
                buttonToShow.classList.remove('d-none');
            }
        });
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', attachSelectButtons);
} else {
    attachSelectButtons();
}
