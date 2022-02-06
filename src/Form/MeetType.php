<?php

namespace App\Form;

use App\Entity\Meet;
use App\Entity\Contact;
use App\Repository\ContactRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class MeetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'required' => false
            ])
            ->add('meetingStart', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('meetingEnd', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('contact', EntityType::class, [
                'class' => Contact::class,
                'query_builder' => function (ContactRepository $cr) {
                    return $cr->createQueryBuilder('c')
                                ->orderBy('c.name', 'ASC');
                },
                'placeholder' => 'Pour quel contact ?',
                'choice_label' => 'name',
            ])
        ;
    }

    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Meet::class,
    //     ]);
    // }
}
