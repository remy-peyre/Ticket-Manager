<?php

namespace TicketBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TicketBundle\Form\TicketType;
use TicketBundle\Entity\Ticket;

/**
 * Ticket controller.
 *
 * @Route("ticket")
 */
class TicketController extends Controller
{
    /**
     * Lists all ticket entities.
     *
     * @Route("/", name="ticket_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tickets = $em->getRepository('TicketBundle:Ticket')->findAll();

        return $this->render('TicketBundle:ticket:index.html.twig', array(
            'tickets' => $tickets,
        ));
    }
	
	/**
	 * Finds and displays a ticket entity.
	 *
	 * @Route("/show-{id}", name="ticket_show")
	 * @Method("GET")
	 */
	public function showAction(Ticket $ticket, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$messages = $em->getRepository('TicketBundle:Message')->findBy(['ticket' => $id]);
		
		return $this->render('TicketBundle:ticket:show.html.twig', array(
			'ticket' => $ticket,
			'messages' => $messages
		));
	}
	
	/**
	 * @Route("/create", name="ticket_create")
	 */
    public function createAction(Request $request)
    {
	    $user = $this->container->get('security.token_storage')->getToken()->getUser();
	    $date = date('Y-m-d H:i:s');
	    
    	$ticket = new Ticket();
	    $ticket->setCreatedAt(new \DateTime($date));
	    $ticket->setUser($user);
	    
	    $form = $this->createForm(TicketType::class, $ticket);
	    $form->handleRequest($request);
	
	    if ($form->isSubmitted() && $form->isValid()) {
		    $em = $this->getDoctrine()->getManager();
		    $em->persist($ticket);
		    $em->flush();
		    
		    return $this->redirectToRoute('ticket_index');
	    }
	
	    return $this->render('TicketBundle:ticket:create.html.twig', [
		    'form' => $form->createView(),
	    ]);
    }
}
