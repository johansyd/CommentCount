<?php
/**
 * This is a test file that is used by CommentCountTest to test
 * that CommentCount can count commented lines in a file.
 *
 * @package CommentCount
 * @category cli-application
 * @author Johan Sydseter <johan@sydseter.com>
 * @copyright GNU/GPL  see: {@link ../../LICENSE.txt}
 */

/**
 * 
 *
throw new Exception(
    "This line should have been commented out, but wasn't");
/*
throw new Exception(
    "This line should have been commented out, but wasn't");
*/

# throw new Exception(
#   "This line should have been commented out, but wasn't");

// throw new Exception(
//  "This line should have been commented out, but wasn't");

/*
throw new Exception(
    "This line should have been commented out, but wasn't");
*/