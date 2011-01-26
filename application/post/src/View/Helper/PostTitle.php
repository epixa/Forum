<?php
/**
 * Epixa - Forum
 */

namespace Post\View\Helper;

use Zend_View_Helper_Abstract as AbstractHelper,
    Post\Model\Post as PostModel;

/**
 * @category   Module
 * @package    Post
 * @subpackage View
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 */
class PostTitle extends AbstractHelper
{
    public function postTitle(PostModel $post)
    {
        $title = $post->title;
        if ($this->view) {
            $title = $this->view->escape($title);
            $url = $this->view->url(array('id' => $post->id), 'post-view', true);
            
            $title = sprintf('<a href="%s">%s</a>', $url, $title);
        }
        
        return $title;
    }
}