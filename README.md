This PHP CLI program counts the number of commented lines and the number of non-commented lines 
and writes the result to standard out. It recognizes all valid php comment markers.

See: http://php.net/manual/en/language.basic-syntax.comments.php

NB:
It will not detect unintentional syntax mistakes and it will count lines with code as comment lines 
if there is a multi-line comment marker on the same line. All forms of inline comments are ignored.

##Install

    curl -sS https://getcomposer.org/installer | sudo php
    ./composer.phar install

##Usage

    bin/comment_count_script.php <php-file> | -help | -help | -h | -?
