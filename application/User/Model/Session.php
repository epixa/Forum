<?php
/**
 * Epixa - Forum
 */

namespace User\Model;

use Epixa\Model\AbstractModel,
    DateTime,
    InvalidArgumentException;

/**
 * @category   Module
 * @package    User
 * @subpackage Model
 * @copyright  2010 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 *
 * @Entity(table="user_session")
 *
 * @property integer         $id
 * @property User\Model\User $user
 * @property string          $key
 * @property DateTime        $lastActivity
 */
class Session extends AbstractModel
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
     * @Column(type="string", name="key", unique=true)
     */
    protected $key;

    /**
     * @Column(type="date", name="last_activity")
     */
    protected $lastActivity;


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
     * @return Session *Fluent interface*
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
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
}