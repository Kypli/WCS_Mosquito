<?php

namespace AppBundle\Form;

use AppBundle\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;


class SearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->setAction('/')
            ->add(
                'search',
                TextType::class, [
                'label' => false,
                'attr' => array('placeholder' => 'Search', 'autocomplete' => 'off'),
                'required' => true,
                'constraints' => array(
                    new NotBlank([
                        'message' => 'You must enter a search.',
                    ]),
                ),
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Search::class,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_search';
    }
}
