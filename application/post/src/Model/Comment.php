<?php
/**
 * Epixa - Forum
 */

namespace Post\Model;

use Epixa\Model\AbstractModel,
    User\Model\User,
    DateTime,
    LogicException,
    InvalidArgumentException,
    Zend_Auth as Auth;

/**
 * @category   Module
 * @package    Post
 * @subpackage Model
 * @copyright  2011 epixa.com - Court Ewing
 * @license    http://github.com/epixa/Epixa/blob/master/LICENSE New BSD
 * @author     Court Ewing (court@epixa.com)
 *
 * @Entity(repositoryClass="Post\Repository\Comment")
 * @Table(name="post_comment")
 * @HasLifecycleCallbacks
 *
 * @property-read integer  $id
 * @property-read DateTime $dateCreated
 * 
 * @property string   $content
 * @property User     $createdBy
 * @property DateTime $dateUpdated
 * @property User     $updatedBy
 * @property Post     $post
 */
class Comment extends AbstractModel
{
    /**
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue
     * 
     * @var integer
     */
    protected $id;
    
    /**
     * @Column(name="content", type="string")
     * 
     * @var string
     */
    protected $content;
    
    /**
     * @Column(name="date_created", type="datetime")
     * 
     * @var DateTime
     */
    protected $dateCreated;
    
    /**
     * @ManyToOne(targetEntity="User\Model\User")
     * @JoinColumn(name="created_by_user_id", referencedColumnName="id")
     * 
     * @var User
     */
    protected $createdBy;
    
    /**
     * @Column(name="date_updated", type="datetime", nullable="true")
     * 
     * @var null|DateTime
     */
    protected $dateUpdated = null;
    
    /**
     * @ManyToOne(targetEntity="User\Model\User")
     * @JoinColumn(name="updated_by_user_id", referencedColumnName="id")
     * 
     * @var null|User
     */
    protected $updatedBy = null;
    
    /**
     * @ManyToOne(targetEntity="Post\Model\Post", inversedBy="comments")
     * @JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;
    
    
    /**
     * Construct a new comment
     * 
     * @param null|array $data
     */
    public function __construct($data = null)
    {
        if ($data !== null) {
            $this->populate($data);
        }
        $this->dateCreated = new DateTime('now');
    }
    
    /**
     * Throws exception so id cannot be set directly
     *
     * @param  integer $id
     * @throws LogicException
     */
    public function setId($id)
    {
        throw new LogicException('Cannot set id directly');
    }
    
    /**
     * Set the comment's content
     * 
     * @param  string $content
     * @return AbstractComment *Fluent interface*
     */
    public function setContent($content)
    {
        $this->content = (string)$content;
        
        return $this;
    }
    
    /**
     * Get the comment's content
     * 
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Set the user that created this comment
     *
     * @param  User $user
     * @return AbstractComment *Fluent interface*
     */
    public function setCreatedBy(User $user)
    {
        $this->createdBy = $user;

        return $this;
    }

    /**
     * Get the user that created this comment
     *
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * Throws exception so creation date cannot be set directly
     * 
     * @param  mixed $data
     * @throws LogicException
     */
    public function setDateCreated($date)
    {
        throw new LogicException('Cannot set creation date directly');
    }
    
    /**
     * Get the date this comment was created
     *
     * @return DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }
    
    /**
     * Set the user that last updated this comment
     *
     * @param  User $user
     * @return AbstractComment *Fluent interface*
     */
    public function setUpdatedBy(User $user)
    {
        $this->updatedBy = $user;

        return $this;
    }

    /**
     * Get the user that created this comment
     *
     * @return User
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
    
    /**
     * Set the date this comment was last updated
     * 
     * @param  integer|string|DateTime $date
     * @return AbstractComment *Fluent interface*
     */
    public function setDateUpdated($date)
    {
        if (is_string($date)) {
            $date = new DateTime($date);
        } else if (is_int($date)) {
            $date = new DateTime(sprintf('@%d', $date));
        } else if (!$date instanceof DateTime) {
            throw new InvalidArgumentException(sprintf(
                'Expecting string, integer or DateTime, but got `%s`',
                is_object($date) ? get_class($date) : gettype($date)
            ));
        }

        $this->dateUpdated = $date;
        
        return $this;
    }
    
    /**
     * Get the date this comment was last updated
     *
     * @return null|DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }
    
    /**
     * @preUpdate
     */
    public function updateLastUpdatedMetaData()
    {
        $auth = Auth::getInstance();
        if (!$auth->hasIdentity()) {
            return;
        }
        
        $this->setUpdatedBy($auth->getIdentity());
        $this->setDateUpdated('now');
    }
}