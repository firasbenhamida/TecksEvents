<?php
/**
 * Created by PhpStorm.
 * User: OMEN
 * Date: 27/02/2019
 * Time: 00:12
 */

namespace MailBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('tel', IntegerType::class)
            ->add('email', EmailType::class)
            ->add('text', TextareaType::class)
            ->add('valider', SubmitType::class) ;
    }
    public function getName()
    {
        return 'Mail';
    }


}