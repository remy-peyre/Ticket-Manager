<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
	 * @ORM\OneToMany(targetEntity="TicketBundle\Entity\Ticket", mappedBy="user")
	 * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id")
	 */
	private $tickets;
	
	/**
	 * @ORM\OneToMany(targetEntity="TicketBundle\Entity\Message", mappedBy="user")
	 * @ORM\JoinColumn(name="message_id", referencedColumnName="id")
	 */
	private $message;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
	
	/**
	 * @return mixed
	 */
	public function getTickets()
	{
		return $this->tickets;
	}
	
	/**
	 * @param mixed $tickets
	 */
	public function setTickets($tickets)
	{
		$this->tickets = $tickets;
	}
	
	/**
	 * @return mixed
	 */
	public function getMessage()
	{
		return $this->message;
	}
	
	/**
	 * @param mixed $message
	 */
	public function setMessage($message)
	{
		$this->message = $message;
	}
 
}

