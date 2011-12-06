<?php
/**
 * Counts the number of commented and uncommented lines 
 * and display the total to the user.
 *
 * @package CommentCount
 * @category cli-application
 * @author Johan Sydseter <johan@sydseter.com>
 * @copyright GNU/GPL see: {@link ../LICENSE.txt}
 */
class CommentCounter 
{
    /**
     * regexp for finding the start of a multi line comment. Inline comments are excluded.
     * NB: There might be executable code on the line before the marker.
     */
    const MULTI_COMMENT_START_MARKER = '~(.*([/][\*])+.*)~';
    
    /**
     * regexp for finding the end of a multi line comment. Inline comments are excluded.
     * NB: There might be executable code on the line after the marker.
     */
    const MULTI_COMMENT_END_MARKER = '~(.*\*/.*)~';
    
    /**
     * regexp for finding a single line comment. Inline comments are excluded.
     */
    const SINGLE_COMMENT_MARKER = '~(^\s*//.*)|(^\s*#.*)~';
    
    /**
     * @var int
     */
    protected $_commentedLines;
    
    /**
     * @var int
     */
    protected $_lines;
    
    /**
     * @var string
     */
    protected $_fileName;
    
    /**
     * 
     * @param string $fileName
     * @throws RuntimeException
     */
    public function __construct($fileName)
    {
        if (!is_string($fileName)){
            throw new RuntimeException("The file name was not a string.");
        }
        
        if (strlen($fileName) == 0){
            throw new RuntimeException("The file name was not specified.");
        }
        
        if (!file_exists($fileName)){
            throw new RuntimeException("The file:" . $fileName . " does not exist");
        }
        if (!is_readable($fileName)){
            throw new RuntimeException("The file:" . $fileName . " is not readable.");
        }
        
        $this->_setFileName($fileName);
        $this->_analyze();
    }
    
    /**
     * @return string;
     */
    public function getFileName()
    {
        return $this->_fileName;
    }
    
    /**
     * @return int
     */
    public function getFileLength()
    {
        return $this->_lines;
    }
    
    /**
     * @return int
     */
    public function getNumOfCommentedLines()
    {
        return $this->_commentedLines;
    }
    
    public function getNumOfNoneCommentedLines()
    {
        return $this->_lines - $this->_commentedLines;
    }
    
    
    /**
     * 
     * @throws RuntimeException
     * @return void
     */
    protected function _analyze()
    {
        $lines = file($this->getFileName(), FILE_IGNORE_NEW_LINES);
        if (!$lines){
            throw new RuntimeException("Failed to read the file:");
        }
        $this->_setLines(count($lines));
        
        $comments = 0;
        $searchingForEndMarker = false;
        $startPos = 0;
        foreach ($lines as $pos => $line){
            
            if(!$searchingForEndMarker){
                if($this->_isMultiLineComment($line) && !$this->_hasEndMarker($line)){
                    $searchingForEndMarker = true;
                    $startPos = $pos;
                    continue;
                }
                
                if ($this->_hasSingleCommentMarker($line)){
                    $comments++;
                    continue;
                }
            } else {
                if ($this->_hasEndMarker($line)){
                    $comments = ($pos - $startPos + 1) + $comments;
                    $searchingForEndMarker = false;
                }
            }
        }
        
        $this->_setNumOfCommentedLines($comments);
        
    }
    
    /**
     * 
     * @param int $lines
     */
    protected function _setNumOfCommentedLines($lines)
    {
        $this->_commentedLines = $lines;
    }
    
    /**
     * 
     * @param int $lines
     */
    protected function _setLines($lines)
    {
        $this->_lines = $lines;
    }
    
    /**
     * 
     * @param string $name
     */
    protected function _setFileName($name)
    {
        $this->_fileName = $name;
    }
    
    /**
     * Will return true even when the line contains executable code, but not if the comment is Inline
     * @param string a line from a php file
     * @return bool
     */
    private function _isMultiLineComment($line)
    {
        return (boolean) preg_match(CommentCounter::MULTI_COMMENT_START_MARKER, $line);
    }
    
    /**
     * Will return true even when the line contains executable code, but not if the comment is Inline.
     * @param string a line from a php file
     * @return bool
     */
    private function _hasEndMarker($line)
    {
        return (boolean) preg_match(CommentCounter::MULTI_COMMENT_END_MARKER, $line);
    }
    
    /**
     * Will not return true when the comment is inline
     * @param string a line from a php file
     * @return bool
     */
    private function _hasSingleCommentMarker($line)
    {
        return (boolean) preg_match(CommentCounter::SINGLE_COMMENT_MARKER, $line);
    }
}