<?php
/**
 * Epixa - Forum
 */

namespace Post\Form;

use Epixa\Form\BaseForm;

/**
 * @category   Module
 * @package    Post
 * @subpackage Form
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class Post extends BaseForm
{
    public function init()
    {
        $this->addElement('text', 'title', array(
            'required' => true,
            'label' => 'Title'
        ));
        
        $this->addElement('textarea', 'description', array(
            'required' => true,
            'label' => 'Description'
        ));

        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Save',
            'order' => 99999
        ));
    }
}