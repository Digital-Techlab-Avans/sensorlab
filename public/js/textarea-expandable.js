document.addEventListener("DOMContentLoaded", function () {
    // Get the elements we need
    const toggleButton = document.getElementById("toggle-description");
    const descriptionTextarea = document.getElementById("description");
    const label = toggleButton.dataset.label;
    const minimumRows = toggleButton.dataset.minimumRows;

    // Get the computed style of the textarea
    const computedStyle = window.getComputedStyle(descriptionTextarea);

    // Calculate the row height based on the font size and line height
    const fontSize = parseFloat(computedStyle.getPropertyValue("font-size"));
    const lineHeight = parseFloat(computedStyle.getPropertyValue("line-height"));
    const rowHeight = Math.max(fontSize, lineHeight);

    // Add an event listener to the textarea for the input event
    descriptionTextarea.addEventListener("input", function () {
        // clone the textarea and set the rows to 1 and calculate the necessary rows
        // this is done to calculate the necessary rows without having to set the rows to the necessary rows
        const clone = descriptionTextarea.cloneNode(true);
        clone.value = descriptionTextarea.value;
        // get the current width of the description textarea
        const width = descriptionTextarea.getBoundingClientRect().width;
        clone.style.maxWidth = Math.floor(width) + "px";
        clone.rows = 1;
        document.body.appendChild(clone);

        const necessaryRows = Math.ceil(clone.scrollHeight / rowHeight);
        // If the textarea is expanded, set its rows to the necessary number of rows to display all content
        if (descriptionTextarea.classList.contains("expanded")) {
            descriptionTextarea.rows = necessaryRows;
        }
        document.body.removeChild(clone);
        checkIfToggleButtonShouldBeShown();
    });

    // Add an event listener to the toggle button
    toggleButton.addEventListener("click", function () {
        // Toggle the class on the textarea
        descriptionTextarea.classList.toggle("expanded");

        // If the textarea is expanded, set its rows to the necessary number of rows
        if (descriptionTextarea.classList.contains("expanded")) {
            // Set the rows to the necessary number of rows to display all content
            descriptionTextarea.rows = Math.ceil(descriptionTextarea.scrollHeight / rowHeight);
            toggleButton.innerText = "Klap " + label + " in";
        } else {
            // Otherwise, set its rows to 3
            descriptionTextarea.rows = minimumRows;
            toggleButton.innerText = "Klap " + label + " uit";
        }
    });

    function checkIfToggleButtonShouldBeShown() {
        // if the inner text of the textarea is less than the minimum rows, don't show the toggle button and set the rows to the minimum rows
        if (Math.ceil(descriptionTextarea.scrollHeight / rowHeight) - 1 <= minimumRows) {
            toggleButton.style.display = "none";
            descriptionTextarea.rows = minimumRows;
        } else {
            toggleButton.style.display = "block";
        }
    }

    checkIfToggleButtonShouldBeShown();
});
