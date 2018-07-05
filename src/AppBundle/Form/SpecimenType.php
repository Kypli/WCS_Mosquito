<?php

namespace AppBundle\Form;

use AppBundle\Form\DataTransformer\IssueToNumberTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class SpecimenType extends AbstractType
{
    private $transformer;

    public function __construct(IssueToNumberTransformer $transformer)
    {
        $this->transformer = $transformer;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('input',
            TextType::class, array(
            'mapped' => false,
            'label' => 'Genus/Species',
            'attr' => array('placeholder' => 'genus & species', 'autocomplete' => 'off')))
            ->add('specie', HiddenType::class)
            ->add('name')

            ->add('gender',ChoiceType::class, array(
                'choices'  => array(
                    'Male' => 'male',
                    'Female' => 'female',)))
            ->add('date', DateType::class, array(
                'widget' => 'single_text'))
            ->add('author', TextType::class, array(

            ))

            ->add('description', null, array(
                'required' => false,
                'data' => 'No description'
            ))
            ->add('imageFile', VichImageType::class)
            ->add('gpsLatitude')
            ->add('gpsLongitude')
            ->add('trueCoordinate', CheckboxType::class, array(
                'label_attr' => array('class' => 'label-for-check btn'),
                'attr' => array('class' => 'check-with-label'),
                'required' => false
            ));

        $builder ->get('specie')
                 ->addModelTransformer($this->transformer);
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