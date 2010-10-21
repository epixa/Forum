<?php
/**
 * Epixa - Forum
 */

namespace User\Model;

use Epixa\Model\AbstractModel,
    Zend_Acl_Role_Interface as RoleInterface,
    LogicException;

/**
 * @category   Module
 * @package    User
 * @subpackage Model
 * @copyright  2010 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 *
 * @Entity
 * @Table(name="user_group")
 *
 * @property integer $id
 * @property string  $name
 */
class Group extends AbstractModel implements RoleInterface
{
    /**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string", name="name")
     */
    protected $name;


    /**
     * Constructor
     *
     * Set the group name
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * Throws exception so id cannot be set directly
     *
     * @param integer $id
     */
    public function setId($id)
    {
        throw new LogicException('Cannot set id directly');
    }

    /**
     * Set the group name
     *
     * @param  string $name
     * @return Group *Fluent interface*
     */
    public function setName($name)
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * Get the group name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the role id for this group
     * 
     * @return string
     */
    public function getRoleId()
    {
        if (!$this->id) {
            throw new LogicException('Group is not yet persisted');
        }

        return __CLASS__ . $this->id;
    }
}