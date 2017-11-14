<?php

namespace TicketBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use TicketBundle\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('subject', TextType::class)
		;
	}
	
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => Ticket::class,
		]);
	}
}