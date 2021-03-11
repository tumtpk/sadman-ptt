<input type="file" id="selector" multiple>
<button onclick="upload()">Upload</button>

<div id="status">No uploads</div>

<script type="text/javascript">

  function convertDate(date){
    var date_auth =
    date.getFullYear() + "" +
    ("00" + (date.getMonth() + 1)).slice(-2) + "" +
    ("00" + (date.getDate()+ 1)).slice(-2) + "" +
    ("00" + date.getHours()).slice(-2) + "" +
    ("00" + date.getMinutes()).slice(-2) + "" +
    ("00" + date.getSeconds()).slice(-2);

    return date_auth;
}
  // `upload` iterates through all files selected and invokes a helper function called `retrieveNewURL`.
  function upload() {
        // Get selected files from the input element.
        var files = document.querySelector("#selector").files;
        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var name = files[i].name;
            var ext = name.split('.').pop().toLowerCase();
            // console.log(file);
            // Retrieve a URL from our server.
            retrieveNewURL(ext ,file, (file, url) => {
                // Upload the file to the server.
                uploadFile(file, url);
            });
        }
    }

    // `retrieveNewURL` accepts the name of the current file and invokes the `/presignedUrl` endpoint to
    // generate a pre-signed URL for use in uploading that file: 
    function retrieveNewURL(ext, file, cb) {
        var namefile = convertDate(new Date()) +'-' +Date.now()+ '.'+ext;
        fetch(`http://117.121.213.103:3100/uploadminio?name=${file.name}&bucket=webboardtextx&namefile=${namefile}`).then((response) => {
            response.text().then((url) => {
                cb(file, url);
            });
        }).catch((e) => {
            console.error(e);
        });
    }

    function uploadFile(file, url) {
        console.log(url);
        if (document.querySelector('#status').innerHTML === 'No uploads') {
            document.querySelector('#status').innerHTML = '';
        }
        fetch(url, {
            method: 'PUT',
            body: file
        }).then(() => {
            // If multiple files are uploaded, append upload status on the next line.
            document.querySelector('#status').innerHTML += `<br>Uploaded ${file.name}.`;
        }).catch((e) => {
            console.error(e);
        });
    }
</script>