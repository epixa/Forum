<?php
/**
 * Epixa - Forum
 */

namespace User\Model;

use Epixa\Model\AbstractModel,
    Epixa\Phpass,
    Epixa\Exception\ConfigException;

/**
 * @category   Module
 * @package    User
 * @subpackage Model
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 *
 * @Entity(repositoryClass="User\Repository\Auth")
 * @Table(name="user_auth")
 *
 * @property integer         $id
 * @property User\Model\User $user
 * @property string          $loginId
 * @property string          $passHash
 */
class Auth extends AbstractModel
{
    /**
     * @var null|Phpass
     */
    protected static $defaultPhpass = null;

    /**
     * @var null|Phpass
     */
    protected $phpass = null;

    /**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="User\Model\User")
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
     * Get the default phpass object
     *
     * @return Phpass
     * @throws ConfigException If no default phpass is configured
     */
    public static function getDefaultPhpass()
    {
        if (self::$defaultPhpass === null) {
            throw new ConfigException('No default phpass configured');
        }

        return self::$defaultPhpass;
    }

    /**
     * Set the default phpass object
     *
     * @param Phpass $phpass
     */
    public static function setDefaultPhpass(Phpass $phpass)
    {
        self::$defaultPhpass = $phpass;
    }

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

    /**
     * Hash the given password
     *
     * @param  string $password
     * @return string
     */
    public function hashPassword($password)
    {
        return $this->getPhpass()->hashPassword($password);
    }

    /**
     * Is the given password the same as the stored password?
     *
     * @param  string $password
     * @return boolean
     */
    public function comparePassword($password)
    {
        return $this->getPhpass()->checkPassword($password, $this->passHash);
    }

    /**
     * Get the phpass object
     *
     * @return Phpass
     */
    public function getPhpass()
    {
        if ($this->phpass === null) {
            $this->setPhpass(self::getDefaultPhpass());
        }

        return $this->phpass;
    }

    /**
     * Set the phpass object
     *
     * @param  Phpass $phpass
     * @return Auth *Fluent interface*
     */
    public function setPhpass(Phpass $phpass)
    {
        $this->phpass = $phpass;

        return $this;
    }
}