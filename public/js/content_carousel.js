document.addEventListener('DOMContentLoaded', () => {
    // Get the file input and upload button
    const fileInput = document.querySelector('#image-input');
    const uploadButton = document.querySelector('#upload-images-button');
    const linkInput = document.querySelector('#link-input');
    const addMediaLinkButton = document.querySelector('#add-media-link-button');

    // Create a list to hold the images
    const imageFiles = new DataTransfer();
    // create a dictionary to hold the image file names and priority as key value pairs

    /**
     * @type {Array.<{type: string, label_text: string, path: string, file: File}>}
     */
    let media = [];

    loadCurrentMediaFromServer();
    checkIfNextAndPreviousButtonsShouldBeHidden();

    // Add a click event listener to the upload button
    uploadButton.addEventListener('click', () => loadImageFromInput());

    addMediaLinkButton?.addEventListener('click', () => addMediaLink());
    const carousel = document.querySelector('#carousel-control');
    carousel.addEventListener('slid.bs.carousel', function (event) {
        changeCarouselImage(event.to);
    });


    function getYoutubeVideoID(path) {
        let video_id = path
            // https://
            .replace(/^https?:?\/?\/?/, '')
            // www.
            .replace(/^www./, '')
            // youtube.com/watch?v=
            .replace(/youtube\.com\/watch\?v=/, '');
        // Remove everything after the video id
        video_id = video_id.split('&')[0];

        return video_id;
    }

    function addMediaLink() {
        const link = linkInput.value;
        if (link === '') {
            return;
        }

        linkInput.value = '';
        if (link.startsWith('https://www.youtube.com/watch?v=')) {
            const mediaLink = {
                type: 'youtube',
                label_text: `📼 ${getYoutubeVideoID(link)}`,
                path: link,
                priority: 1,
            };

            media.push(mediaLink);
            updateImages();
            updateImagePriorityAndCarousel();
        } else {
            alert('Deze link is niet ondersteund. Probeer een youtube link te gebruiken.');
        }
    }

    async function loadCurrentMediaFromServer() {
        const mediaImages = await Promise.all(initialImagePaths.map(async (path) => {
            const filename = path.split('/').pop();
            // Loads the image from the server
            const response = await fetch(path);
            const blobFile = await response.blob();
            const file = new File([blobFile], filename, {type: 'image/png'});
            return {
                type: 'local_image',
                label_text: filename,
                path: path,
                file: file,
                priority: initialImagePriority[filename] ?? 1,
            };
        }));

        for (let mediaImage of mediaImages) {
            imageFiles.items.add(mediaImage.file);
        }

        const mediaVideos = initialVideoPaths.map((path) => {
            return {
                type: 'youtube',
                label_text: `📼 ${getYoutubeVideoID(path)}`,
                path: path,
                priority: initialVideoPriority[path] ?? 1,
            };
        });

        const unorderedMedia = [];
        unorderedMedia.push(...mediaImages);
        unorderedMedia.push(...mediaVideos);

        const orderedMedia = unorderedMedia.sort((a, b) => a.priority - b.priority);

        // Fix duplicate priorities e.g. [1, 1, 2, 3, 3, 4] -> [1, 2, 3, 4, 5, 6]
        for (let media of orderedMedia) {
            const nextMedia = orderedMedia[orderedMedia.indexOf(media) + 1];
            if (nextMedia !== undefined && media.priority >= nextMedia.priority) {
                nextMedia.priority = media.priority + 1;
            }
        }
        media.push(...orderedMedia);

        updateImages();
    }

    function loadImageFromInput() {
        document.getElementById("content-filetype-error").hidden = true;
        for (let file of fileInput.files) {
            if (file.type.match('image.*')) {
                if (onlyOne) {
                    media = [];
                    imageFiles.items.clear();
                }
                media.push({
                    priority: 1,
                    type: 'local_image',
                    label_text: file.name,
                    path: URL.createObjectURL(file),
                    file: file,
                });
                imageFiles.items.add(file);
            } else {
                document.getElementById("content-filetype-error").hidden = false;
            }
        }
        updateImages();
        updateImagePriorityAndCarousel();
    }

    function updateImages() {
        for (let file of imageFiles.files) {
            const reader = new FileReader();
            reader.addEventListener('load', () => {
                const image = document.createElement('img');
                // Set the image source to the data URL generated by the reader
                image.setAttribute("aria-hidden", "true");
            });
            // Read the file as a data URL
            reader.readAsDataURL(file);
        }
        fileInput.files = imageFiles.files;
        updateCarouselContent(imageFiles.files);
        updateCarouselLabels();
        checkIfNextAndPreviousButtonsShouldBeHidden();
        // Call enableDragSort on document ready
        enableDragSort('drag-sort-enable');

        const thumbnailContainer = document.querySelector('.carousel-thumbnails');
        thumbnailContainer.innerHTML = "";

        for (let i = 0; i < media.length; i++) {
            const mediaItem = media[i];
            const card = document.createElement('div');
            const cardBody = document.createElement('div');

            card.classList.add('card', 'mb-3', 'thumbnail-card');
            card.appendChild(cardBody);

            const thumbnail = document.createElement('img');

            if (mediaItem.type === 'youtube') {
                thumbnail.src = `https://img.youtube.com/vi/${getYoutubeVideoID(mediaItem.path)}/0.jpg`;
                const playButton = document.createElement('div');
                playButton.classList.add('play-button');
                playButton.setAttribute("data-bs-target", "#carousel-control");
                playButton.setAttribute("data-bs-slide-to", i);
                playButton.addEventListener('click', () => changeCarouselImage(i));

                cardBody.appendChild(playButton);

            } else {
                thumbnail.src = mediaItem.path;
            }

            thumbnail.classList.add('thumbnail');
            thumbnail.setAttribute("data-bs-target", "#carousel-control");
            thumbnail.setAttribute("data-bs-slide-to", i);
            thumbnail.addEventListener('click', () => changeCarouselImage(i));

            cardBody.appendChild(thumbnail);
            thumbnailContainer.appendChild(card);
        }
        changeCarouselImage(0);
    }

    function changeCarouselImage(index) {
        const activeThumbnail = document.querySelector('.thumbnail-card.selected-thumbnail');

        if (activeThumbnail) activeThumbnail.classList.remove('selected-thumbnail');

        const thumbnails = document.querySelectorAll('.thumbnail-card');

        if (thumbnails[index]) thumbnails[index].classList.add('selected-thumbnail');
    }


    function checkIfNextAndPreviousButtonsShouldBeHidden() {
        const nextButton = document.querySelector("#carousel-next-button");
        const previousButton = document.querySelector("#carousel-previous-button");
        const explanation = document.querySelector("#file-name-explanation");
        const imageFileNames = document.querySelector("#carousel-label-list");
        const indicatorContainer = document.querySelector("#carousel-indicators-container");
        const shouldHideButtons = media.length <= 1;
        nextButton.hidden = shouldHideButtons;
        previousButton.hidden = shouldHideButtons;
        explanation.hidden = shouldHideButtons || imageFileNames.hidden !== false;
        indicatorContainer.hidden = shouldHideButtons;
    }

    function updateCarouselContent(files) {
        const carouselInner = document.querySelector("#image-carousel-container");

        // Clear the carousel
        carouselInner.innerHTML = "";

        for (let mediaItem of media) {
            const item = document.createElement("div");
            item.classList.add("carousel-item");
            item.classList.add("w-100", "h-100");
            item.style.objectFit = "contain";
            if (mediaItem.type === 'local_image') {
                for (const file of files) {
                    if (file.name !== mediaItem.file.name) {
                        continue;
                    }
                    const img = document.createElement("img");
                    img.src = URL.createObjectURL(file);
                    img.ariaHidden = true;
                    img.classList.add("w-100", "h-100");
                    img.style.objectFit = "contain";
                    img.style.borderRadius = "20px";
                    item.appendChild(img);
                }
            } else {
                item.innerHTML = `<iframe style="width: 100%; height: 100%" src="https://www.youtube.com/embed/${getYoutubeVideoID(mediaItem.path)}" loading="lazy" title="YouTube video player" allow="encrypted-media; picture-in-picture;" allowfullscreen></iframe>`;
            }
            carouselInner.appendChild(item);
        }

        let imageFilePriority = {};
        let youtubeVideoPriority = {};
        for (let mediaItem of media) {
            if (mediaItem.type === 'local_image') {
                imageFilePriority[mediaItem.file.name] = media.indexOf(mediaItem) + 1;
            } else if (mediaItem.type === 'youtube') {
                youtubeVideoPriority[mediaItem.path] = media.indexOf(mediaItem) + 1;
            }
        }

        const imageFilePriorityInput = document.querySelector('#image-file-priority');
        imageFilePriorityInput.value = JSON.stringify(imageFilePriority);
        const youtubePriorityInput = document.querySelector('#youtube-video-priority');
        youtubePriorityInput.value = JSON.stringify(youtubeVideoPriority);

        // activate the first item
        carouselInner?.firstChild?.classList.add("active");

        updateCarouselIndicators(files);
    }

    // Reads media data and updates the labels
    function updateCarouselLabels() {
        const carouselLabelList = document.querySelector("#carousel-label-list");
        carouselLabelList.innerHTML = "";

        for (let mediaItem of media) {
            const listItem = document.createElement('li');
            listItem.setAttribute('draggable', true);
            listItem.classList.add('carousel-source');
            listItem.setAttribute('data-name', mediaItem.path);

            listItem.media = mediaItem;
            mediaItem.listItem = listItem;

            const labelText = document.createElement('div');
            listItem.appendChild(labelText);
            labelText.classList.add('carousel-source-label');
            labelText.innerText = mediaItem.label_text;

            const deleteButton = document.createElement('button');
            listItem.appendChild(deleteButton);
            deleteButton.innerHTML = 'X';
            deleteButton.classList.add('carousel-delete-button');
            deleteButton.addEventListener('click', (e) => {
                // Delete the image file from the file input form element
                if (mediaItem.type === 'local_image') {
                    for (let i = 0; i < imageFiles.files.length; i++) {
                        if (imageFiles.files[i].name === mediaItem.file.name) {
                            imageFiles.items.remove(i);
                            break;
                        }
                    }
                }

                // Removes the coupled media item
                media.splice(media.indexOf(mediaItem), 1);

                updateImages();

                e.preventDefault();
            });

            carouselLabelList.appendChild(listItem);
        }
        updateImagePriority();
    }

    function updateCarouselIndicators() {
        const carouselIndicators = document.querySelector(".carousel-indicators");

        carouselIndicators.innerHTML = "";

        for (let i = 0; i < media.length; i++) {
            const button = document.createElement("button");
            button.setAttribute("type", "button");
            button.setAttribute("data-bs-target", "#carousel-control");
            button.setAttribute("data-bs-slide-to", i);
            if (i === 0) {
                button.classList.add("active");
                button.setAttribute("aria-current", "true");
            }
            carouselIndicators.appendChild(button);
        }
    }

    function enableDragSort(listClass) {
        // Get all lists with the provided class name
        const sortableLists = document.getElementsByClassName(listClass);

        // For each list, enable drag sorting
        for (let list of sortableLists) {
            // For each item in the list, enable drag sorting
            for (let item of list.children) {
                // Set draggable attribute and add event listeners for drag events
                item.setAttribute('draggable', true);
                item.addEventListener('drag', handleDrag);
                item.addEventListener('dragend', handleDrop);
            }
        }
    }

    function handleDrag(event) {
        const selectedItem = event.target
        const list = selectedItem.parentNode
        const x = event.clientX
        const y = event.clientY

        // Add drag-sort-active class to the selected item
        selectedItem.classList.add('drag-sort-active');

        // Find the item at the drop location
        let swapItem = document.elementFromPoint(x, y) === null ? selectedItem : document.elementFromPoint(x, y);

        // If the drop location is within the same list, move the selected item to the drop location
        if (list === swapItem.parentNode) {
            swapItem = swapItem !== selectedItem.nextSibling ? swapItem : swapItem.nextSibling;
            list.insertBefore(selectedItem, swapItem);
        }
    }

    function handleDrop(event) {
        event.target.classList.remove('drag-sort-active');
        updateImagePriorityAndCarousel();
    }

    // Store order from carousel labels and update carousel content
    function updateImagePriority() {
        const carouselLabels = document.getElementById('carousel-label-list');

        media = [];

        for (let listItem of carouselLabels.children) {
            media.push(listItem.media);
        }
    }

    function updateImagePriorityAndCarousel() {
        updateImagePriority();
        updateCarouselContent(imageFiles.files);
    }
});
