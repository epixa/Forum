<?php
/**
 * Epixa - Forum
 */

namespace User\Model;

use Epixa\Model\AbstractModel;

/**
 * @category   Module
 * @package    User
 * @subpackage Model
 * @copyright  2010 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 *
 * @Entity(table="user")
 *
 * @property integer            $id
 * @property string             $email
 * @property string             $alias
 * @property User\Model\Auth    $auth
 * @property User\Model\Profile $profile
 */
class User extends AbstractModel
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
     * @OneToOne(targetEntity="User\Model\Auth", mappedBy="user")
     */
    protected $auth;

    /**
     * @OneToOne(targetEntity="User\Model\Profile", mappedBy="user")
     */
    protected $profile;


    /**
     * Throws exception so id cannot be set directly
     * 
     * @param integer $id 
     */
    public function setId($id)
    {
        throw new \LogicException('Cannot set id directly');
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
     * Set the user's auth
     * 
     * @param  Auth $auth
     * @return User *Fluent interface*
     */
    public function setAuth(Auth $auth)
    {
        $this->auth = $auth;
        
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
}