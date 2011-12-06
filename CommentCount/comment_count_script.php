#!/usr/bin/php
<?php
require_once 'src/CommentCounter.php';

/**
 * Script for finding the number of lines in a php file that is commented.
 *
 * @package CommentCount
 * @category cli-application
 * @author Johan Sydseter <johan@sydseter.com>
 * @copyright GNU/GPL see: {@link LICENSE.txt}
 */

if ($argc < 2 | !isset($argv[1])) {
?>

This scripts takes a php file name as argument and prints the number of commented lines to output.

Usage:
<?php echo $argv[0]; ?> <filename>

<filename> The php file. 
With the --help, -help, -h, or -? options, you can get this help.

<?php 
} elseif(in_array($argv[1], array('--help', '-help', '-h', '-?'))) {
?>

Usage:
<?php echo $argv[0]; ?> <filename>
    
<filename> The php file.
With the --help, -help, -h, or -? options, you can get this help.

<?php
} else {
    try {
        $commentCounter = new CommentCounter($argv[1]);
    
        $fileSize = $commentCounter->getFileLength();
        $commentedLines = $commentCounter->getNumOfCommentedLines();
        $noneCommentedLines = $commentCounter->getNumOfNoneCommentedLines();
        $fileName = $commentCounter->getFileName();
    } catch (Exception $e) {
        $file = $e->getFile();
        $line = $e->getLine();
        $message = $e->getMessage();
        $error = <<<ERROR
    
    Exception caught in {$argv[0]}
    File: $file
    Line: $line
    Message: $message
    
ERROR;
        error_log($error);
        echo 'Script ended abnormally. Exception was thrown.';
        exit(0);
    }
    $out = <<<TEXT
    
    File name: $fileName
    Number of lines: $fileSize
    Number of commented lines: $commentedLines
    Number of none-commented lines : $noneCommentedLines


TEXT;
echo $out;
}