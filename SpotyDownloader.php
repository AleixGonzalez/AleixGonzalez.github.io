<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpotyDownloader</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #121212;
            color: #1DB954;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            margin-left: 10px;
            width: 50px;
            height: 50px;
        }
        h1 {
            color: #1DB954;
            font-size: 3em;
        }
        form {
            margin: 0 auto;
            width: 50%;
            max-width: 500px;
            min-width: 300px;
        }
        label {
            font-size: 1.5em;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 1.2em;
            border: 2px solid #1DB954;
            border-radius: 5px;
            margin-top: 10px;
        }
        button {
            background-color: #1DB954;
            color: #121212;
            border: none;
            padding: 15px 30px;
            font-size: 1.5em;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #14833b;
        }
        .song-info {
            margin-top: 20px;
            text-align: center;
        }
        .song-info img {
            max-width: 300px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .song-info h2 {
            margin: 10px 0;
            font-size: 2em;
        }
        .song-info a {
            color: #1DB954;
            text-decoration: none;
            font-size: 1.5em;
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            border: 2px solid #1DB954;
            border-radius: 5px;
        }
        .song-info a:hover {
            background-color: #1DB954;
            color: #121212;
        }
        .hidden { 
            display: none; 
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SpotyDownloader</h1>
        <img src="https://static.vecteezy.com/system/resources/previews/016/716/458/non_2x/spotify-icon-free-png.png" alt="Spotify Icon">
    </div>
    <form id="music-form">
        <label for="song-url">URL de la canción de Spotify:</label>
        <input type="text" id="song-url" name="song-url" required>
        <button type="submit">Descargar</button>
    </form>
    <div id="song-info" class="song-info hidden">
        <img id="song-cover" src="" alt="Portada de la canción">
        <h2 id="song-title"></h2>
        <a id="download-button" href="#" download>Descargar Canción</a>
    </div>

    <script>
        $(document).ready(function() {
            $('#music-form').on('submit', function(event) {
                event.preventDefault(); // Evitar el comportamiento por defecto del formulario
                let songUrl = $('#song-url').val();
                
                // Eliminar 'intl-es/' de la URL si está presente
                songUrl = songUrl.replace('/intl-es/', '/');

                const encodedSongUrl = encodeURIComponent(songUrl);

                const settings = {
                    async: true,
                    crossDomain: true,
                    url: `https://spotify-downloader9.p.rapidapi.com/downloadSong?songId=${encodedSongUrl}`,
                    method: 'GET',
                    headers: {
                        'x-rapidapi-key': 'fc9a982916mshe1f3ad77f3e39ddp1f9b06jsna58c9c5eaba0',
                        'x-rapidapi-host': 'spotify-downloader9.p.rapidapi.com'
                    }
                };

                $.ajax(settings).done(function(response) {
                    console.log(response); // Imprimir la respuesta en la consola
                    if (response.success) {
                        const downloadUrl = response.data.downloadLink;
                        const songTitle = response.data.title;
                        const songCover = response.data.cover;

                        $('#song-cover').attr('src', songCover);
                        $('#song-title').text(songTitle);
                        $('#download-button').attr('href', downloadUrl);
                        $('#song-info').removeClass('hidden');
                    } else {
                        alert(response.message);
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown); // Imprimir detalles del error en la consola
                    alert('Error al descargar la canción. Por favor, intenta de nuevo.');
                });
            });
        });
    </script>
</body>
</html>