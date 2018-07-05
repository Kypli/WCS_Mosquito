<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class SpecimenEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
            ->add('gender', ChoiceType::class, array(
                'choices'  => array(
                    'Male' => 'male',
                    'Female' => 'female', )))
            ->add('date', DateType::class, array(
                'widget' => 'single_text'))
            ->add('author')
            ->add('description')
            ->add('imageFile', VichImageType::class,[

                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false,
            ])
            ->add('gpsLatitude')
            ->add('gpsLongitude')
            ->add('trueCoordinate', CheckboxType::class, array(
                'label_attr' => array('class' => 'label-for-check btn'),
                'attr' => array('class' => 'check-with-label'),
                'required' => false
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Entity\Specimen'
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_specimen';
    }
}