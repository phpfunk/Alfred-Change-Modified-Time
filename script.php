<?php

//Function to get all files recursively from a directory
function getFiles($dir, $files=array())
{
    $files = (empty($files)) ? array($dir) : $files;
    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            $file = $dir . '/' . $entry;
            if (substr($entry, 0, 1) != '.') {
                if (is_dir($file)) {
                   array_push($files, $file);
                    $files = getFiles($file, $files);
                }
                else {
                    array_push($files, $file);
                }
            }
        }

        closedir($handle);
    }

    return $files;
}

// Get the file or directory from Alfred
// Set the plural to null
$file = '{query}';
$s    = null;

// If is a directory
// Get all the files
// Set plural to 's'
// Else just create the array
if (is_dir($file)) {
    $s     = 's';
    $files = getFiles($file);
}
else {
    $files = array($file);
}

// Loop through each file and update the modtime to now
foreach ($files as $file) {
    $r = shell_exec('touch –mt ' . '"' . $file . '"');
}

// Print message
print 'File' . $s . ' updated to the current date.';