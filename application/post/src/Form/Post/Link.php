<?php
/**
 * Epixa - Forum
 */

namespace Post\Form\Post;

use Post\Form\Post as StandardPost;

/**
 * @category   Module
 * @package    Post
 * @subpackage Form
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class Link extends StandardPost
{
    public function init()
    {
        parent::init();
        
        $this->getElement('type')->setValue('link');
        
        $this->addElement('text', 'url', array(
            'required' => true,
            'label' => 'Url'
        ));
    }
}