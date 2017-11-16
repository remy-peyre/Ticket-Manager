<?php

namespace TicketBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use TicketBundle\Entity\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextType::class)
	        ->add('ticket', EntityType::class, [
		        'class' => 'TicketBundle\Entity\Ticket',
		        'choice_label' => 'subject'
	        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}