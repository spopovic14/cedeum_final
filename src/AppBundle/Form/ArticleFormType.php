<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/23/2017
 * Time: 10:12 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticleFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('festival', ChoiceType::class, array('choices' => array(
                '/' => null,
                'Mater Terra' => 'Mater Terra',
                'Bitef Polifonija' => 'Bitef Polifonija'
            )))
            ->add('picture', FileType::class, array('label' => 'Picture'))
            ->add('description')
            ->add('content')
            ->add('releaseDate')

            ->add('titleEn')
            ->add('descriptionEn')
            ->add('contentEn');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => 'AppBundle\Entity\Article'
        ]);
    }


}
