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
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 *
 * @Entity
 * @Table(name="user_profile")
 *
 * @property integer         $id
 * @property User\Model\User $user
 * @property string          $email
 */
class Profile extends AbstractModel
{
    /**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @OneToOne(targetEntity="User\Model\User", inversedBy="profile")
     */
    protected $user;

    /**
     * @Column(type="string", name="email")
     */
    protected $email;


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
     * @return Profile *Fluent interface*
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Set the email
     *
     * @param  string $email
     * @return Profile *Fluent interface*
     */
    public function setEmail($email)
    {
        $this->email = (string)$email;

        return $this;
    }
}