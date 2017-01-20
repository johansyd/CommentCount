<?php

use CommentCount\CommentCounter;

define('DATA_TEST_DIR', __DIR__ . DIRECTORY_SEPARATOR . 'data');
/**
 * CommentCounter test case.
 * 
 * @package CommentCount
 * @category cli-application
 * @author Johan Sydseter <johan@sydseter.com>
 * @copyright GNU/GPL see: {@link ../LICENSE.txt}
 */
class CommentCounterTest extends PHPUnit_Framework_TestCase
{
    
    /**
     * @var CommentCounter
     */
    private $_commentCounter;
    
    private static $_testFile = 'testFile.php';
    
    private $_testFileName;
    
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        
        $this->_testFileName = DATA_TEST_DIR . DIRECTORY_SEPARATOR . CommentCounterTest::$_testFile;

        $this->_commentCounter = new CommentCounter($this->_testFileName);
    
    }
    
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->_commentCounter = null;
    }
    
    /**
     * Tests CommentCounter->__construct()
     */
    public function test__construct()
    {
        
        try {
            new CommentCounter($this->_testFileName);
        } catch (RuntimeException $e) {
            $this->fail($e->getMessage());
        }
        
        try {
            //Runtime exception when file does not exist
            new CommentCounter($this->_testFileName . hash('sha1', 'almost always unique'));
            $this->fail("Should have thrown an exception");
        } catch (RuntimeException $e) {
            //empty
        }
        
        try {
            //runtime exception when not a string
            new CommentCounter(array(""));
            $this->fail("Should have thrown an exception");
        } catch (RuntimeException $e) {
            //empty
        }
        
        try {
            //runtime exception when string is empty
            new CommentCounter("");
            $this->fail("Should have thrown an exception");
        } catch (RuntimeException $e) {
            //empty
        }
    }
    
    public function testGetFileName()
    {
        $this->assertEquals($this->_commentCounter->getFileName(), $this->_testFileName, 
                "The file name could not be retrieved");
    } 
    
    public function testGetFileLength()
    {
        $this->assertEquals(31, $this->_commentCounter->getFileLength(), 
                'The length of:' . CommentCounterTest::$_testFile . ' should be 31 lines');
    }
    
    public function testGetCommentedLines()
    {
        $this->assertEquals(26, $this->_commentCounter->getNumOfCommentedLines(),
                'The number of commented lines:' . CommentCounterTest::$_testFile . ' should be 26 lines');
    }
    
    public function testGetNoneCommentedLines()
    {
        $this->assertEquals(5, $this->_commentCounter->getNumOfNoneCommentedLines(),
                'The number of uncommented lines:' . CommentCounterTest::$_testFile . ' should be 5 lines');
    }
    
    /**
     * Test the regular expressions used in the private methods
     */
    public function testCommentRegExp()
    {
        $lines = file($this->_testFileName, FILE_IGNORE_NEW_LINES);
        
        if (!$lines){
            $this->fail("Could not open the file: $this->_testFileName for reading");
        }

        if(!$this->_isMatched($lines, CommentCounter::MULTI_COMMENT_START_MARKER)){
            $this->fail("Could not match the pattern:" . CommentCounter::MULTI_COMMENT_START_MARKER);
        }
        
        if(!$this->_isMatched($lines, CommentCounter::MULTI_COMMENT_END_MARKER)){
            $this->fail("Could not match the pattern:" . CommentCounter::MULTI_COMMENT_END_MARKER);
        }
        
        if(!$this->_isMatched($lines, CommentCounter::SINGLE_COMMENT_MARKER)){
            $this->fail("Could not match the pattern:" . CommentCounter::SINGLE_COMMENT_MARKER);
        }
        
    }
    
    /**
     * 
     * @param array $lines
     * @param string $pattern
     */
    private function _isMatched(array $lines, $pattern)
    {
        foreach($lines as $pos => $line) {
            if(preg_match($pattern, $line)){
                return true;
            }
        }
        return false;
    }
}

