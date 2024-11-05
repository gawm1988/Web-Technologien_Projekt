/**
 * Quelle: http://www.it-gecko.de/html5-upload-thumbnails-vorschau-erstellen.html
 */
function fileThumbnail(files) {
    var thumb = document.getElementById("thumbnail");

    thumb.innerHTML = "";

    if (!files)
        return;

    for (var i = 0; i < files.length; i++) {
        var file = files[i];

        if (!file.type.match(/image.*/))
            continue;

        var img = document.createElement("img");
        var reader = new FileReader();

        reader.onload = (function (tImg) {
            return function (e) {
                tImg.src = e.target.result;
            };
        })(img);

        reader.readAsDataURL(file);

        img.width = 200;

        thumb.appendChild(img);
    }
}