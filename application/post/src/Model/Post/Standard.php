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
 * @property string $description
 */
class Standard extends AbstractPost
{
    /**
     * @Column(name="description", type="string", nullable="true")
     * 
     * @var null|string
     */
    protected $description = null;
}