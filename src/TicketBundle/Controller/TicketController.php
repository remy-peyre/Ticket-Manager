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
	
	    $role = $this->getUser()->getRoles();
	    if ($role[0] == 'ROLE_SUPER_ADMIN' || $role[0] == 'ROLE_ADMIN') {
		    $tickets = $em->getRepository('TicketBundle:Ticket')->findAll();
	    } else {
		    $tickets = $this->getUser()->getTickets();
	    }

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
		//$messages = $em->getRepository('TicketBundle:Message')->findBy(['ticket' => $id]);
		
		return $this->render('TicketBundle:ticket:show.html.twig', array(
			'ticket' => $ticket,
			//'messages' => $messages
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
	
	/**
	 * @Route("/delete-{id}", name="ticket_delete")
	 */
	public function deleteAction(Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		$ticket = $em->getRepository('TicketBundle:Ticket')->find($id);
		
		// remove all messages before removing ticket
		$messages = $em->getRepository('TicketBundle:Message')->findBy(['ticket' => $id]);
		if (null !== $messages) {
			foreach ($messages as $msg) {
				$em->remove($msg);
			}
		}
		
		$em->remove($ticket);
		$em->flush();
		
		return $this->redirectToRoute('ticket_index');
	}

    /**
     * @Route("/update-{id}", name="ticket_update")
     */
    public function updateAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $ticket = $em->getRepository('TicketBundle:Ticket')->find($id);

        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ticket->setSubject($form->getData()->getSubject());
            $em->flush();

            return $this->redirectToRoute('ticket_index');
        }

        return $this->render('TicketBundle:ticket:update.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);

    }
}
