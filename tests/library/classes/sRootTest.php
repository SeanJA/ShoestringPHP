<?php
ini_set("include_path", "../library/classes".PATH_SEPARATOR."../../../library/classes".PATH_SEPARATOR.ini_get("include_path"));
require_once 'PHPUnit/Framework.php';

require_once 'sroot.class.php';

/**
 * Test class for sRoot.
 * Generated by PHPUnit on 2009-06-19 at 13:42:01.
 */
class sRootTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var    sRoot
     * @access protected
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     *
     * @access protected
     */
    protected function setUp()
    {
        $this->object = new sRoot;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     *
     * @access protected
     */
    protected function tearDown()
    {
    }
}
?>
