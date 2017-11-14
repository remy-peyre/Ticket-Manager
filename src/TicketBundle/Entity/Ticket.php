<?php

namespace TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="TicketBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="ticket")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Message", inversedBy="ticket")
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
	public function getUser()
	{
		return $this->user;
	}
	
	/**
	 * @param mixed $user
	 */
	public function setUser($user)
	{
		$this->user = $user;
	}
    
    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Ticket
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
	
    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return Ticket
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
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

