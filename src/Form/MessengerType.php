<?php
declare(strict_types=1);

namespace App\Form;


use App\Entity\Education\Group;
use App\Entity\Message;
use App\Entity\Teacher;
use App\Entity\User;
use App\Repository\Education\GroupRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessengerType extends AbstractType
{

    /**
     * @var \Symfony\Component\Security\Core\Security
     */
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        /** @var User $receiver */
        $receiver = $options['receiver'];

        if (!empty($receiver)) {
            $builder->add('receiver', TextType::class, [
                'data' => $receiver->getFirstName() .  ' ' . $receiver->getLastName(),
                'disabled' => true,
                'label' => 'До',
                'constraints' => [new NotBlank()]
            ]);
        } else {
            $builder->add('receiver', EntityType::class, [
                'class' => User::class,
                'label' => 'До',
                'query_builder' => function (UserRepository $userRepo) use ($user) {
                    return $userRepo->createQueryBuilder('u')
                        ->where('u != :user')
                        ->setParameter('user', $user);
                },
                'choice_label' => function (User $user) {
                    return $user->getFirstName() . ' ' . $user->getLastName() . ' | ' . $user->getEmail();
                },
                'attr' => ['class' => 'my-select2-js'],
                'placeholder' => 'Избери...',
                'constraints' => [
                    new NotBlank()
                ]
            ]);
        }



        $builder->add('text', TextareaType::class, [
            'label' => 'Съобщение',
            'attr' => ['placeholder' => 'Текст на съобщението', 'rows' => '5', 'class' => 'col-6'],
            'constraints' => [new NotBlank()]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        return $resolver->setDefaults([
            'required' => false,
            'data_class' => Message::class,
            'receiver' => null
        ]);

    }
}