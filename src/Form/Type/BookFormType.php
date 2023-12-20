<?php
namespace App\Form\Type;


use App\Form\Model\BookDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class BookFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder 
        ->add('title', TextType::class)
        ->add('base64Image', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BookDto::class,
        ]);
    }



    //se tienen que agregar los siguientes metodos para evitar 
    //pasarle el nombre del formulario al crear un objeto book, ejemplo:
    // {
    //     "book_form:
    //     {
    //       "title": "Los intocables"
    //     }
    // }
    //nota book_form es un nombre, que usa symfony de forma convencional para asignarle el nombre al form

    public function getBlockPrefix()
    {
        return '';
    }

    public function getName()
    {
        return '';
    }

}