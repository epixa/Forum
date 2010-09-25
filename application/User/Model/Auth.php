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
 * @Entity(table="user_auth")
 *
 * @property integer          $id
 * @property User\Model\User  $user
 * @property string           $loginid
 * @property string           $passhash
 */
class Auth extends AbstractModel
{
    /**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="User\Model\User", inversedBy="auth")
     */
    protected $user;

    /**
     * @Column(type="string", name="login_id")
     */
    protected $loginId;

    /**
     * @Column(type="string", name="pass_hash", length=256, nullable=true)
     */
    protected $passHash = null;


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
     * Set the user
     *
     * @param  User $user
     * @return Auth *Fluent interface*
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set the auth login id
     *
     * @param  string $loginId
     * @return Auth *Fluent interface*
     */
    public function setLoginId($loginId)
    {
        $this->loginId = (string)$loginId;

        return $this;
    }

    /**
     * Set the auth pass hash
     *
     * @param  string $passhash
     * @return Auth *Fluent interface*
     */
    public function setPassHash($passhash)
    {
        $this->passHash = (string)$passhash;

        return $this;
    }
}