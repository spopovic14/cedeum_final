<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 2/23/2017
 * Time: 10:12 PM
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

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
            ->add('project', EntityType::class, array(
                'class' => 'AppBundle:Project',
                'query_builder' => function(EntityRepository $er) {
                    return $er->findActiveQuery();
                },
                'choice_label' => 'name',
                'required' => false,
                'empty_data' => null,
            ))
            ->add('picture', FileType::class, array('label' => 'Picture'))
            ->add('description')
            ->add('content', TextAreaType::class, array(
                'attr' => array('rows' => 25)
            ))
            ->add('releaseDate')

            ->add('titleEn')
            ->add('descriptionEn')
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
           'data_class' => 'AppBundle\Entity\Article'
        ]);
    }


}
