<?php

namespace florian\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username')
                ->add('email')
                ->add('enabled')
                ->add('roles', 'choice', array(
                    'choices' => array(
                        'ROLE_UTILISATEUR' => 'Utilisateur',
                        'ROLE_ADMIN' => 'Admin',
                    ),
                    'multiple'=>true,
                    'required' => true,
                    'empty_value' => 'Choisir le rôle',
                    'empty_data' => null
        ));
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'florian\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'florian_userbundle_user';
    }
}
