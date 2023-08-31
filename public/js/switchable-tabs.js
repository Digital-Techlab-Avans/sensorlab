const tabButton = document.getElementById('tab-button');
const dropdownMenuItems = document.querySelectorAll('.dropdown-menu .dropdown-item');
const tabMenuItems = document.querySelectorAll('.tab-menu-item');

window.addEventListener('load', () => {
    checkActiveDropdownItem();
});

dropdownMenuItems.forEach(item => {
    function interact() {
        tabButton.textContent = item.textContent;
        checkActiveDropdownItem();
        checkActiveTabMenuItem();
    }
    item.addEventListener('click', () => interact());
    item.addEventListener('keyup', (event) => {
        if (event.key === 'Enter') {
            interact();
        }
    });
});

tabMenuItems.forEach(item => {
    item.addEventListener('click', () => {
        tabButton.textContent = item.textContent;
        checkActiveDropdownItem();
    });
});

function checkActiveDropdownItem() {
    dropdownMenuItems.forEach(item => {
        item.classList.remove('active');
        if (item.textContent === tabButton.textContent) {
            item.classList.add('active');
        }
    });
}

function checkActiveTabMenuItem() {
    tabMenuItems.forEach(item => {
        item.classList.remove('active');
        if (item.textContent === tabButton.textContent) {
            item.classList.add('active');
        }
    });
}

// make sure the correct dropdown item is active on page load
checkActiveDropdownItem();
const targetDivs = document.querySelectorAll('.tab-pane');

// Create a new instance of MutationObserver for each target div
targetDivs.forEach((targetDiv) => {
  const observer = new MutationObserver((mutationsList) => {
    // Check each mutation that occurred
    for (let mutation of mutationsList) {
      if (
        mutation.type === 'attributes' &&
        mutation.attributeName === 'class' &&
        targetDiv.classList.contains('active') &&
        targetDiv.classList.contains('show')
      ) {
        const tabName = targetDiv.getAttribute('data-tab-name');
        tabButton.textContent = tabName;
      }
    }
  });

  // Start observing the target div for attribute changes
  observer.observe(targetDiv, { attributes: true });
});
