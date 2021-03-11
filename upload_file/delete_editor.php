<?php
    // Get src.
    $src = $_POST["src"];

    // Check if file exists.
    if (file_exists(getcwd() "../../upload_images/uploads_editor/" . $src)) {
      // Delete file.
      unlink(getcwd() "../../upload_images/uploads_editor/" . $src);
    }
?>