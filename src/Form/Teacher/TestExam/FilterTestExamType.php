<?php
declare(strict_types=1);

namespace App\Form\Teacher\TestExam;


use App\DTO\TestFilterDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterTestExamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMethod("GET");
        $builder->add('title', TextType::class, [
            'label'=> 'Заглавие'
        ]);

        $builder->add('from', DateType::class, [
            'widget' => 'single_text',
            'html5' => false,
            'label_html' => true,
            'format' => 'dd.MM.yyyy',
            'label' => '<i class="fa fa-calendar"></i>',
            'row_attr' => ['class' => 'input-group date'],
            'attr' => ['class' => 'datepicker-field']
        ]);

        $builder->add('to', DateType::class, [
            'widget' => 'single_text',
            'html5' => false,
            'label_html' => true,
            'format' => 'dd.MM.yyyy',
            'label' => '<i class="fa fa-calendar"></i>',
            'row_attr' => ['class' => 'input-group date'],
            'attr' => ['class' => 'datepicker-field']
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => TestFilterDTO::class
        ]);
    }
}