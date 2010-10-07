<?php

require '../includes.php';
require_once 'library/helpers/html.helper.php';

/**
 * Test class for htmlHelper.
 */
class htmlHelperTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown() {
		
	}

	public function testHrefWithNoHttp(){
		$value = href('test.com', 'test', array(), false);
		$this->assertEquals('<a href="http://localhost/shoestring/index.php/test.com">test</a>', $value);
	}

	public function testHrefWithHttp(){
		$value = href('http://test.com', 'test', array(), false);
		$this->assertEquals('<a href="http://test.com">test</a>', $value);
	}

	public function testHrefWithHttps(){
		$value = href('https://test.com', 'test', array(), false);
		$this->assertEquals('<a href="https://test.com">test</a>', $value);
	}

	public function testHrefWithGit(){
		$value = href('git://github.com/SeanJA/ShoestringPHP.git', 'ShoestringPHP', array(), false);
		$this->assertEquals('<a href="git://github.com/SeanJA/ShoestringPHP.git">ShoestringPHP</a>', $value);

		$value = href('git@github.com:SeanJA/ShoestringPHP.git', 'ShoestringPHP', array(), false);
		$this->assertEquals('<a href="git@github.com:SeanJA/ShoestringPHP.git">ShoestringPHP</a>', $value);
	}

	public function testHrefWithMailto(){
		$value = href('mailto:test@test.com', 'Test', array(), false);
		$this->assertEquals('<a href="mailto:test@test.com">Test</a>', $value);
	}

	public function testHrefWithftp(){
		$value = href('ftp://test.com', 'Test', array(), false);
		$this->assertEquals('<a href="ftp://test.com">Test</a>', $value);
	}

	public function testHrefWithftps(){
		$value = href('ftps://test.com', 'Test', array(), false);
		$this->assertEquals('<a href="ftps://test.com">Test</a>', $value);
	}

	public function testHrefWithAttributes(){
		$value = href('http://test.com', 'Test', array('class'=>'external', 'id'=>'test', 'rel'=>'_blank'), false);
		$this->assertEquals('<a class="external" id="test" rel="_blank" href="http://test.com">Test</a>', $value);
	}

	public function testEmailLink(){
		$value = email_link('test@test.com', array(), false);
		$this->assertEquals('<a href="mailto:test@test.com">test@test.com</a>', $value);
	}

	public function testValidDocTypes(){
		$tests = array(
			'xhtml1_strict'=>'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">',
			'xhtml1_trans'=>'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">',
			'html4_strict'=>'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">',
			'html4_trans'=>'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
  "http://www.w3.org/TR/html4/loose.dtd">',
			'html5'=>'<!DOCTYPE html>',
		);
		foreach($tests as $type=>$expected){
			$this->assertEquals($expected, docType($type, false));
		}
	}
	public function testUnknownDocType(){
		try{
			docType('unkown doctype');
			$this->fail('Should have thrown an error');
		} catch(Exception $e){
			$this->assertEquals('Unknown Doctype "unkown doctype".', $e->getMessage());
		}
	}
	public function testMetaTag(){
		$result = metaTag(array('name'=>'description', 'content'=>'some content'), false);
		$this->assertEquals('<meta name="description" content="some content" />', $result);
	}
	public function testMetaTagWithDashes(){
		$result = metaTag(array('http-equiv'=>'Content-Type', 'content'=>'text/html;charset=ISO-8859-1'), false);
		$this->assertEquals('<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />', $result);
	}
	public function testCharset(){
		$result = charset(false);
		$this->assertEquals('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />', $result);
	}
}