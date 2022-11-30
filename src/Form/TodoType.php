<?php
namespace App\Form;

use App\Entity\Todo;
use App\Entity\Status;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Form\FormBuilderInterface;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "attr" => ["class"=>"form-control mb-2"]
                ])
            ->add('description', TextareaType::class, [
                "attr" => ["class"=>"form-control mb-2"]
                ])
            ->add('category', TextType::class, [
                "attr" => ["class"=>"form-control mb-2"]
                ])
            ->add('priority', ChoiceType::class, [
                "choices" => ["low"=>"low", "normal"=>"normal", "high"=>"high"], 
                "attr" => ["class"=>"form-control mb-2"]
                ])
            ->add('dueDate', DateTimeType::class, [
                "attr" => ["class"=>"form-control mb-2"]
                ])
                ->add('fk_status', EntityType::class, [
                "class"=>Status::class,
                "choice_label"=>"name",
                "attr"=>["class"=>"form-control mb-2" ],
                ])
            ->add('pictureUrl', FileType::class, [
                'label'=>'Upload Picture',
                'mapped'=>false,
                'required'=>false,
                'constraints'=>[
                    new File([
                    'maxSize'=>'1024k',
                    'mimeTypes'=> [
                        'image/png',
                        'image/jpeg',
                        'image/jpg',
                    ],
                    'mimeTypesMessage'=>'Please upload a valid image file.',
                ])
                ],
                'attr'=> ['class'=>'form-control mb-2'],
            ])

            ->add('save', SubmitType::class, [
                "attr" => ["class"=>"btn btn-primary", "style"=>"margin-bottom:15px"]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'=>Todo::class
        ]);
    }
}