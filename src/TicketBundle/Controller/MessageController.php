<?php

namespace TicketBundle\Controller;

use TicketBundle\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TicketBundle\Form\MessageType;
use Symfony\Component\HttpFoundation\Request;


/**
 * Message controller.
 *
 * @Route("message")
 */
class MessageController extends Controller
{

    /**
     * @Route("/create-{ticketId}", name="message_create")
     */
    public function createAction(Request $request, $ticketId)
    {
	    $user = $this->container->get('security.token_storage')->getToken()->getUser();
	    $date = date('Y-m-d H:i:s');
	
	    $em = $this->getDoctrine()->getManager();
	    $ticket = $em->getRepository('TicketBundle:Ticket')->find($ticketId);
	    
        $message = new Message();
	    $message->setCreatedAt(new \DateTime($date));
	    $message->setUser($user);
	    $message->setTicket($ticket);
	    
	    $form = $this->createForm(MessageType::class, $message);
	    $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('ticket_show', ['id' => $ticketId]);
        }

        return $this->render('TicketBundle:message:create_message.html.twig', [
            'form' => $form->createView(),
        ]);
    }
	
	/**
	 * @Route("/delete-{id}", name="message_delete")
	 */
    public function deleteAction(Request $request, $id)
    {
	    $em = $this->getDoctrine()->getManager();
	    $message = $em->getRepository('TicketBundle:Message')->find($id);
	
	    $user = $this->container->get('security.token_storage')->getToken()->getUser();
	    if ($user->hasRole('ROLE_ADMIN') || $user->hasRole('ROLE_SUPER_ADMIN')) {
		    $em->remove($message);
		    $em->flush();
	    }
	
	    return $this->redirectToRoute('ticket_index');
    }

    /**
     * @Route("/update-{id}", name="message_update")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository('TicketBundle:Message')->find($id);

        $form = $this->createForm(MessageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setContent($form->getData()->getContent());
            $em->flush();

            return $this->redirectToRoute('ticket_index');
        }

        return $this->render('TicketBundle:message:update.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }
}
