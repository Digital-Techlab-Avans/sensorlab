const renderer = new marked.Renderer();

// Use Bootstrap table styling
renderer.table = (header, body) => {
    return `<table class="table">${header}${body}</table>`;
};

// Use target="_blank" for all links
renderer.link = (href, title, text) => {
    return `<a target="_blank" href="${href}" title="${title}">${text}</a>`;
}

for (let iframe of document.getElementsByTagName('iframe')) {
    iframe.style.minWidth = '100%';
    iframe.style.maxWidth = '100%';
    iframe.style.minHeight = 'min(auto, 100vw)';
    iframe.style.maxHeight = 'min(auto, 100vw)';
}
