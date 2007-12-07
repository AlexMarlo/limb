<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2007 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */

/**
 * @tag form:errors
 * @forbid_end_tag   
 * @parent_tag_class lmbMacroFormTag
 * @restrict_self_nesting
 * @package macro
 * @version $Id$
 */
class lmbMacroFormErrorsTag extends lmbMacroTag
{
  function generate($code)
  {
    $form = $this->findParentByClass('lmbMacroFormTag')->getRuntimeVar();
    
    $to = $this->get('to');
    
    $code->writePhp("{$to} = {$form}->getErrorList();\n");

    parent :: generate($code);
  }
}


