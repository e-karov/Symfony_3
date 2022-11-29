<?php
namespace App\Form;

use App\Entity\Todo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ["attr" => ["class"=>"form-control mb-2"]])
            ->add('description', TextareaType::class, ["attr" => ["class"=>"form-control mb-2"]])
            ->add('category', TextType::class, ["attr" => ["class"=>"form-control mb-2"]])
            ->add('priority', ChoiceType::class, [
                "choices" => ["low"=>"low", "normal"=>"normal", "high"=>"high"], 
                "attr" => ["class"=>"form-control mb-2"]
                ])
            ->add('dueDate', DateTimeType::class, ["attr" => ["class"=>"form-control mb-2"]])

            ->add('save', SubmitType::class, ["attr" => ["class"=>"btn btn-primary"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'=>Todo::class
        ]);
    }
}