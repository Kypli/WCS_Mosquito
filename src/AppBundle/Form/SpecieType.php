<?php

namespace AppBundle\Form;

use AppBundle\Entity\Genus;
use AppBundle\Repository\GenusRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class SpecieType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('genus', EntityType::class, array(
                'class' => Genus::class,
                'choice_label' => 'fullName',
                'attr' => array(
                    'class' => 'genus-type'
                ),
                'label_attr' => ['class' => 'btn label-species'],
                'query_builder' => function(GenusRepository $entityRepository)
                {
                    return $entityRepository->createQueryBuilder('s')
                        ->orderBy('s.name');
                }
            ))
            ->add('name', TextType::class, array(
                'label_attr' => ['class' => '']
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Specie'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_specie';
    }

}
