<?php
/**
 * Epixa - Forum
 */

namespace Post\Model\Post;

use Post\Model\AbstractPost;

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
class Link extends AbstractPost
{
    /**
     * Column(name="url", type="string")
     * 
     * @var string
     */
    protected $url;
}