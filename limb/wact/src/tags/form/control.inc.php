<?php
/**
 * Limb Web Application Framework
 *
 * @link http://limb-project.com
 *
 * @copyright  Copyright &copy; 2004-2007 BIT
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 * @version    $Id: control.inc.php 5690 2007-04-19 13:03:28Z serega $
 * @package    wact
 */

/**
 * Ancester tag class for input controls
 * @access protected
 * @package    wact
 */
class WactControlTag extends WactRuntimeComponentHTMLTag
{
  /**
   * Returns the identifying server ID. It's value it determined in the
   * following order;
   * <ol>
   * <li>The XML id attribute in the template if it exists</li>
   * <li>The XML name attribute in the template if it exists</li>
   * <li>The value of $this->ServerId</li>
   * <li>An ID generated by the getNewServerId() function</li>
   * </ol>
   * @return string value identifying this component
   */
  function getServerId()
  {
    if ($this->hasAttribute('wact:id')) {
      return $this->getAttribute('wact:id');
    } else if ($this->hasAttribute('id')) {
      return $this->getAttribute('id');
    } else if ($this->hasAttribute('name')) {
      return str_replace('[]', '', $this->getAttribute('name'));
    } else if (!empty($this->ServerId)) {
      return $this->ServerId;
    } else {
      $this->ServerId = self :: generateNewServerId();
      return $this->ServerId;
    }
  }

  /**
   * @return void
   */
  function prepare()
  {
    if (!$this->getBoolAttribute('name')) {
      if ( $this->getBoolAttribute('wact:id') ) {
        $this->setAttribute('name', $this->getAttribute('wact:id'));
      } else if ( $this->getBoolAttribute('id') ) {
        $this->setAttribute('name', $this->getAttribute('id'));
      } else {
        $this->raiseRequiredAttributeError('name');
      }
    }

    parent::prepare();
  }

  /**
   * @param WactCodeWriter
   * @return void
   */
  function generateConstructor($code_writer)
  {
    parent::generateConstructor($code_writer);

    if ($this->hasAttribute('errorclass'))
    {
      $code_writer->writePHP($this->getComponentRefCode() . '->errorclass = ');
      $code_writer->writePHPLiteral($this->getAttribute('errorclass'));
      $code_writer->writePHP(';');
    }

    if ($this->hasAttribute('errorstyle'))
    {
      $code_writer->writePHP($this->getComponentRefCode() . '->errorstyle = ');
      $code_writer->writePHPLiteral($this->getAttribute('errorstyle'));
      $code_writer->writePHP(';');
    }

    if ($this->hasAttribute('displayname'))
    {
      $code_writer->writePHP($this->getComponentRefCode() . '->displayname = ');
      $code_writer->writePHPLiteral($this->getAttribute('displayname'));
      $code_writer->writePHP(';');
    }
  }

  function preGenerate($code_writer)
  {
    if($this->hasAttribute('given_value'))
    {
      $this->attributeNodes['given_value']->generatePreStatement($code_writer);

      $code_writer->writePhp($this->getComponentRefCode() .
                      '->setGivenValue(');
      $this->attributeNodes['given_value']->generateExpression($code_writer);
      $code_writer->writePhp(');');

      $this->attributeNodes['given_value']->generatePostStatement($code_writer);
      unset($this->attributeNodes['given_value']);
    }

    parent :: preGenerate($code_writer);
  }
}

?>
