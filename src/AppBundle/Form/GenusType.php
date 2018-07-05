<?php

namespace AppBundle\Form;

use AppBundle\Entity\SubFamily;
use AppBundle\Repository\SubFamilyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class GenusType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subfamily', EntityType::class, array(
                'class' => SubFamily::class,
                'choice_label' => 'fullName',
                'label_attr' => ['class' => 'label-name'],
                'query_builder' => function(SubFamilyRepository $entityRepository)
                {
                    return $entityRepository->createQueryBuilder('sf')
                        ->orderBy('sf.name');
                }
            ))
            ->add('name', TextType::class, array(
                'label_attr' => ['class' => 'label-name']
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Genus'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_genus';
    }

}
