/**
 *  Fetch API, erstellt mithilfe von ChatGPT
 */
// Initialer Offset und Anzahl neu zu ladener Beiträge, nur gemeinsam mit index.php $initialLimit anpassen
let offset = 3;
const limit = 3;

document.getElementById('load-more-button').addEventListener('click', function () {
    fetch(`beitraege-laden.php?offset=${offset}&limit=${limit}`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                document.getElementById('load-more-button').style.display = 'none';
                return;
            }

            const container = document.querySelector('.sculpture-container');
            data.forEach(beitrag => {
                const div = document.createElement('div');
                div.classList.add('sculpture-card');
                div.innerHTML = `
                    <a href="beitrag-anzeigen.php?id=${beitrag.id}">
                        <img src="${beitrag.picture}" alt="${beitrag.title}"><br>
                        <div class="card-title">${beitrag.title}</div>
                    </a>
                `;
                container.appendChild(div);
            });
            offset += limit;

            // Wenn weniger Beiträge zurückkommen als das Limit, verstecke den Button, da alle Beiträge geladen sind.
            if (data.length < limit) {
                document.getElementById('load-more-button').style.display = 'none';
            }
        })
        .catch(error => console.error('Fehler bei der Anfrage:', error));
});
