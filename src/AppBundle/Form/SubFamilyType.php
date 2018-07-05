<?php

namespace AppBundle\Form;

use AppBundle\Entity\Family;
use AppBundle\Repository\FamilyRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubFamilyType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('family', EntityType::class, array(
                'class' => Family::class,
                'choice_label' => 'fullName',
                'label_attr' => ['class' => 'label-name'],
                'query_builder' => function(FamilyRepository $entityRepository)
                {
                    return $entityRepository->createQueryBuilder('f')
                        ->orderBy('f.name');
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
            'data_class' => 'AppBundle\Entity\SubFamily'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_subfamily';
    }

}
