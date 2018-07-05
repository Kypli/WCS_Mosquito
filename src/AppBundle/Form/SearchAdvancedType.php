<?php
/**
 * Created by PhpStorm.
 * User: wilder15
 * Date: 20/12/17
 * Time: 09:28
 */

namespace AppBundle\Form;

use AppBundle\Entity\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SearchAdvancedType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add(
                'name',
                TextType::class,
                array(
                    'required' => false,
                    'label' => 'Search',
                    'attr' => array('placeholder' => 'enter your search !'),
                )
            )
            ->add(
                'date',
                DateType::class,
                array(
                    'required' => false,
                    'label' => 'Date ',
                    'widget' => 'single_text',
                    'attr' => array('placeholder' => 'enter the date'),
                )
            )
            ->add(
                'author',
                TextType::class,
                array(
                    'required' => false,
                    'label' => 'Author ',
                    'attr' => array('placeholder' => 'enter the Author'),

                )
            )
            ->add(
                'gpsLatitude',
                TextType::class,
                array(
                    'required' => false,
                    'label' => 'Gps Latitude ',
                    'attr' => array('placeholder' => 'enter the Latitude'),

                )
            )
            ->add(
                'gpsLongitude',
                TextType::class,
                array(
                    'required' => false,
                    'label' => 'Gps Longitude ',
                    'attr' => array('placeholder' => 'enter the Longitude'),

                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     *
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Search::class
        ));
    }

}