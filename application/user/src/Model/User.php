<?php
/**
 * Epixa - Forum
 */

namespace User\Model;

use Epixa\Model\AbstractModel,
    Epixa\Acl\MultiRoles,
    Zend_Acl_Role_Interface as RoleInterface,
    Zend_Acl_Resource_Interface as ResourceInterface,
    Doctrine\Common\Collections\ArrayCollection,
    User\Model\Profile,
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
 * @Table(name="user")
 *
 * @property integer         $id
 * @property string          $alias
 * @property Profile         $profile
 * @property ArrayCollection $groups
 */
class User extends AbstractModel implements RoleInterface, MultiRoles, ResourceInterface
{
    /**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="string", name="alias")
     */
    protected $alias;

    /**
     * @OneToOne(targetEntity="User\Model\Profile", mappedBy="user")
     */
    protected $profile;

    /**
     * @ManyToMany(targetEntity="User\Model\Group")
     * @JoinTable(name="user_group_assoc",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="group_id", referencedColumnName="id")}
     *      )
     */
    protected $groups;


    /**
     * Constructor
     *
     * Initialize the groups collection
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
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
     * Set the user's alias
     *
     * @param  string $alias
     * @return User *Fluent interface*
     */
    public function setAlias($alias)
    {
        $this->alias = (string)$alias;

        return $this;
    }

    /**
     * Set the user's profile
     *
     * @param  Profile $profile
     * @return User *Fluent interface*
     */
    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get the user's groups
     *
     * @return ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set the user's groups
     *
     * @param  array $groups
     * @return User *Fluent interface*
     */
    public function setGroups(array $groups)
    {
        $this->groups->clear();
        foreach ($groups as $group) {
            $this->addGroup($group);
        }

        return $this;
    }

    /**
     * Add a new user group
     *
     * @param  Group $group
     * @return User *Fluent interface*
     */
    public function addGroup(Group $group)
    {
        $this->groups->add($group);

        return $this;
    }

    /**
     * Get the role id for this user
     *
     * @return string
     */
    public function getRoleId()
    {
        if (!$this->id) {
            throw new LogicException('User is not yet persisted');
        }

        return __CLASS__ . '-' . $this->id;
    }

    /**
     * Get the user's roles
     *
     * @return array
     */
    public function getRoles()
    {
        $roles = array($this->getRoleId());
        foreach ($this->groups as $group) {
            if ($group instanceof RoleInterface) {
                array_push($roles, $group);
            }
        }

        return $roles;
    }

    /**
     * Get the resource identifier for this model
     *
     * @return string
     */
    public function getResourceId()
    {
        return __CLASS__;
    }
}