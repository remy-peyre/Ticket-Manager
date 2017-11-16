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
     * Lists all message entities.
     *
     * @Route("/", name="message_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('TicketBundle:Message')->findAll();

        return $this->render('TicketBundle:message:index.html.twig', array(
            'messages' => $messages,
        ));
    }

    /**
     * Finds and displays a message entity.
     *
     * @Route("/show-{id}", name="message_show")
     * @Method("GET")
     */
    public function showAction(Message $message)
    {

        return $this->render('TicketBundle:message:show.html.twig', array(
            'message' => $message,
        ));
    }

    /**
     * @Route("/create", name="message_create")
     */
    public function createAction(Request $request)
    {
	    $user = $this->container->get('security.token_storage')->getToken()->getUser();
	    $date = date('Y-m-d H:i:s');
	    
        $message = new Message();
	    $message->setCreatedAt(new \DateTime($date));
	    $message->setUser($user);
	    
	    $form = $this->createForm(MessageType::class, $message);
	    $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('messages_index');
        }

        return $this->render('TicketBundle:message:create_message.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
