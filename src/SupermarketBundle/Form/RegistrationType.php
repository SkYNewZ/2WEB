<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 14/05/17
 * Time: 22:39
 */

namespace SupermarketBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('delivery', null, array('label' => 'form.delivery', 'translation_domain' => 'FOSUserBundle'))
	        ->add('billing', null, array('label' => 'form.billing', 'translation_domain' => 'FOSUserBundle'))
			->add('lastName', null, array('label' => 'form.lastname', 'translation_domain' => 'FOSUserBundle'))
			->add('firstName', null, array('label' => 'form.firstname', 'translation_domain' => 'FOSUserBundle'))
		;
	}

	public function getParent()
	{
		return 'FOS\UserBundle\Form\Type\RegistrationFormType';
	}

	public function getBlockPrefix()
	{
		return 'supermarket_user_registration';
	}
}