<?php

namespace florian\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContext;

class ArticleType extends AbstractType {

    private $securityContext;

    public function __construct(SecurityContext $securityContext) {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $user = $this->securityContext->getToken()->getUser();

        $builder
                ->add('titre', 'text')
                //On a une classe utilisateur pour cette information
                //->add('auteur', 'text', array('read_only' => true, 'data' => $user->getUsername()))
                ->add('contenu', 'ckeditor', array(
                    'config' => array(
                        'toolbar' => array(
                            array(
                                'name' => 'basicstyles',
                                'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Justify', '-', 'RemoveFormat'),
                            ),
                            array(
                                'name' => 'lien',
                                'items' => array('Link', 'Unlink'),
                            )
                        ),
                        'uiColor' => '#ffffff',
                    )
                ))
                ->add('dateCreation', 'genemu_jquerydate', array(
                    'widget' => 'single_text'
                ))
                ->add('imageArticle', new ImageArticleType());
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'florian\BlogBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'florian_blogbundle_article';
    }

}
