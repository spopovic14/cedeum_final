<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/23/2017
 * Time: 6:11 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content', TextAreaType::class, array(
                'attr' => array('rows' => 25)
            ))

            ->add('titleEn')
            ->add('contentEn', TextAreaType::class, array(
                'attr' => array('rows' => 25)
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => 'AppBundle\Entity\Page'
        ]);
    }

}
