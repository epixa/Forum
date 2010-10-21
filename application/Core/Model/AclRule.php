<?php
/**
 * Epixa - Forum
 */

namespace Core\Model;

use Epixa\Model\AbstractModel,
    Zend_Acl_Assert_Interface as AclAssertion,
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
 * @HasLifecycleCallbacks
 * @Table(name="core_acl_rule")
 *
 * @property integer $id
 * @property string  $resourceId
 * @property string  $roleId
 */
class AclRule extends AbstractModel
{
    const BROWSE = 'browse';
    const READ   = 'read';
    const EDIT   = 'edit';
    const ADD    = 'add';
    const DELETE = 'delete';

    /**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string", name="resource_id")
     */
    protected $resourceId;

    /**
     * @Column(type="string", name="role_id")
     */
    protected $roleId;

    /**
     * @Column(type="string", name="privilege")
     */
    protected $privilege = null;

    /**
     * @Column(type="string", name="assertion")
     */
    protected $assertion = null;

    /**
     * @var null|AclAssertion
     */
    protected $_assertionObject = null;

    /**
     * @var array
     */
    protected static $_privileges = array(
        self::BROWSE, self::READ, self::EDIT, self::ADD, self::DELETE
    );


    /**
     * Get all available privilege
     * 
     * @return array
     */
    public static function getAllPrivileges()
    {
        return self::$_privileges;
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
     * Set the resource id
     * 
     * @param  string $resourceId
     * @return Acl *Fluent interface*
     */
    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    /**
     * Set the role id
     * 
     * @param  string $roleId
     * @return Acl *Fluent interface*
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Set the privilege
     *
     * @param  null|string $privilege
     * @return Acl *Fluent interface*
     */
    public function setPrivilege($privilege = null)
    {
        $this->privilege = $privilege;

        return $this;
    }

    /**
     * Set the assertion
     * 
     * @param  null|AclAssertion $assertion
     * @return AclRule *Fluent interface*
     */
    public function setAssertion(AclAssertion $assertion = null)
    {
        if (null === $assertion) {
            $this->assertion = null;
            $this->_assertionObject = null;
        } else {
            $this->assertion = get_class($assertion);
            $this->_assertionObject = $assertion;
        }

        return $this;
    }

    /**
     * Get the assertion
     * 
     * @return null|AclAssertion
     */
    public function getAssertion()
    {
        return $this->_assertionObject;
    }

    /**
     * Update the assertion object based on the database
     *
     * @PostLoad
     */
    public function synchAssertion()
    {
        if (null === $this->assertion) {
            $this->_assertionObject = null;
        } else if (null === $this->_assertionObject
                || get_class($this->_assertionObject) == $this->assertion) {
            $assertion = new $this->assertion;
            $this->setAssertion($assertion);
        }
    }
}