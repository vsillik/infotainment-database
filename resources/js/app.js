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

const attachPerPageSelect = () => {
  const perPageSelects = document.getElementsByClassName('pagination-per-page');

  for (const perPageSelect of perPageSelects) {
      perPageSelect.addEventListener('change', () => {
          const url = new URL(window.location.href);

          url.searchParams.delete('page');
          url.searchParams.set('per_page', perPageSelect.value);

          window.location.href = url.toString();
      });
  }
};

const onLoad = () => {
    attachSelectButtons();
    attachPerPageSelect();
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', onLoad);
} else {
    onLoad();
}
