<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Fichiers HTML disponibles</h1>
    <ul>
        <?php
        function listerFichiersHTML($dir) {
            $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
            foreach ($rii as $file) {
                if ($file->isFile() && strtolower($file->getExtension()) === 'html') {
                    $path = $file->getPathname();
                    $relPath = str_replace(__DIR__ . DIRECTORY_SEPARATOR, '', $path);
                    echo '<li><a href="' . htmlspecialchars($relPath) . '">' . htmlspecialchars($relPath) . '</a></li>';
                }
            }
        }

        listerFichiersHTML(__DIR__);
        ?>
    </ul>
</body>
</html>
