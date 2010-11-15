<?php
/**
 * Epixa - Forum
 */

namespace User\Model;

use Epixa\Model\AbstractModel,
    Epixa\Auth\Storage\SessionEntity,
    DateTime,
    InvalidArgumentException,
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
 * @Table(name="user_session")
 *
 * @property integer         $id
 * @property User\Model\User $user
 * @property string          $key
 * @property DateTime        $lastActivity
 */
class Session extends AbstractModel implements SessionEntity
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
     * @Column(type="string", name="session_key", unique=true)
     */
    protected $key;

    /**
     * @Column(type="datetime", name="last_activity")
     */
    protected $lastActivity;


    /**
     * Constructor
     *
     * Set the date of last activity,
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->updateLastActivity()
             ->setUser($user)
             ->setKey($this->_generateKey($user));
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
     * Set the user associated with this session
     *
     * @param  User $user
     * @return Session *Fluent interface*
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the user associated with this session
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the session key
     *
     * @param  string $key
     * @return Session *Fluent interface*
     */
    public function setKey($key)
    {
        $this->key = (string)$key;

        return $this;
    }

    /**
     * Get the session key
     * 
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set the date of the last activity
     *
     * @param  string $date
     * @return Auth *Fluent interface*
     */
    public function setLastActivity($date)
    {
        if (is_string($date)) {
            $date = new DateTime($date);
        } else if (is_int($date)) {
            $date = new DateTime(sprintf('@%d', $date));
        } else if (!$date instanceof DateTime) {
            throw new InvalidArgumentException(sprintf(
                'Expecting string, integer or DateTime, but got `%s`',
                is_object($date) ? get_class($date) : gettype($class)
            ));
        }

        $this->lastActivity = $date;

        return $this;
    }

    /**
     * Set the date of last activity to right now
     *
     * @return Session *Fluent interface*
     */
    public function updateLastActivity()
    {
        $this->setLastActivity('now');

        return $this;
    }

    /**
     * Generate a new session key
     * 
     * @param  User $user
     * @return string
     */
    protected function _generateKey(User $user)
    {
        return sha1(serialize($user) . microtime());
    }
}