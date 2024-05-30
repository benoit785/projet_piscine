function searchText() {
    // Remove previous highlights
    let content = document.getElementById('content');
    let paragraphs = content.getElementsByTagName('p');
    for (let p of paragraphs) {
        p.innerHTML = p.innerHTML.replace(/<span class="highlight">(.*?)<\/span>/g, '$1');
    }

    // Get search input
    let input = document.getElementById('searchInput').value.toLowerCase();

    if (input) {
        for (let p of paragraphs) {
            let text = p.innerHTML.toLowerCase();
            let startIndex = text.indexOf(input);

            if (startIndex != -1) {
                let endIndex = startIndex + input.length;
                let originalText = p.innerHTML.substring(startIndex, endIndex);
                let highlightedText = `<span class="highlight">${originalText}</span>`;
                p.innerHTML = p.innerHTML.substring(0, startIndex) + highlightedText + p.innerHTML.substring(endIndex);
            }
        }
    }
}
