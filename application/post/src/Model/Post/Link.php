<?php
/**
 * Epixa - Forum
 */

namespace Post\Model\Post;

use Post\Model\Post as BasePost;

/**
 * @category   Module
 * @package    Post
 * @subpackage Model
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 *
 * @Entity
 *
 * @property string $url
 */
class Link extends BasePost
{
    /**
     * @var string
     */
    protected $type = 'link';
    
    /**
     * Column(name="url", type="string")
     * 
     * @var string
     */
    protected $url;
}