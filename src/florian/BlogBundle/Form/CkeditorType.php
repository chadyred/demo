<?php
// src/florian/BlogBundle/Form/Type/CkeditorType.php

namespace florian\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CkeditorType extends AbstractType
{
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'attr' => array('class' => 'ckeditor')
    ));
  }

  public function getParent()
  {
    return 'textarea';
  }

  public function getName()
  {
    return 'ckeditor';
  }}
