This PHP CLI program counts the number of commented lines and the number of non-commented lines 
and writes the result to standard out. It recognizes all valid php comment markers.

[![Todo](https://badge.waffle.io/johansyd/CommentCount.png?label=todo&title=Todo)](https://waffle.io/johansyd/CommentCount?utm_source=badge)
[![Paused](https://badge.waffle.io/johansyd/CommentCount.png?label=paused&title=Paused)](https://waffle.io/johansyd/CommentCount?utm_source=badge)
[![In progress](https://badge.waffle.io/johansyd/CommentCount.png?label=in%20progress&title=In%20progress)](https://waffle.io/johansyd/CommentCount?utm_source=badge)
[![Up for review](https://badge.waffle.io/johansyd/CommentCount.png?label=ready%20for%20review&title=Up%20for%20review)](https://waffle.io/johansyd/CommentCount?utm_source=badge)
[![In staging](https://badge.waffle.io/johansyd/CommentCount.png?label=staged&title=Staged)](https://waffle.io/johansyd/CommentCount?utm_source=badge)

See: http://php.net/manual/en/language.basic-syntax.comments.php

NB:
It will not detect unintentional syntax mistakes and it will count lines with code as comment lines 
if there is a multi-line comment marker on the same line. All forms of inline comments are ignored.

##Install

    curl -sS https://getcomposer.org/installer | php
    ./composer.phar install

##Test

    composer compile

##Usage

    bin/comment_count_script.php <php-file> | -help | -help | -h | -?

