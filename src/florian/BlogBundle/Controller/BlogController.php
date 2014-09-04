<?php

// src/florian/BlogBundle/Controller/BlogController.php

namespace florian\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use florian\BlogBundle\Entity\Article;
use florian\BlogBundle\Form\ArticleType;

// Nous n'avons plus besoin du use pour l'objet Response
// use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller {

    public function indexAction($page) {
        //la page devant être entrée sera cette un nombre mais plus grand que 1 ainsi on vérifie si c'est le cas
        if ($page < 1) {
            //On va générer une page 404 que l'on pourra personnaliser par la suite
            throw $this->createNotFoundException('Page non trouvée : ' . $page . ' ! ');
        }


        //Je définit ici mon nombre d'article par page pour ma pagination
        $nombreArticleParPage = 4;

        //J'appel ma fonction de pagination en lui passant en paramêtre le nombre d'article par page et la première page
        //ATTENTION : $articleRecent est une instance de la classse Paginator() récupéré depuis la couche modèle réalisé
        //via ArticleRepository()
        $articlesRecent = $this->getDoctrine()
                ->getManager()
                ->getRepository('florianBlogBundle:Article')
                ->myFindArticleRecent($nombreArticleParPage, $page);

        // On utilise le raccourci : il crée un objet Response
        // Et lui donne comme contenu le contenu du template
        $this->get('session')->getFlashBag()->add('info', 'Choissisez un article !');
        $id = $this->get('session')->get('user_id');

        //Le count va ici recupérer les article sans les limit d'affichage, donc pas uniquement les 5 article grâce à la classe abstraite 'Countable' avec
        //sa méthode 'Countable::count()'. Ici on arrondi à l'entier supérieur du nombre d'article total afin d'avoir le nombre de page.
        //Exemple : 12 article / 5 = 2.4 donc 3 page
        return $this->render('florianBlogBundle:Blog:index.html.twig', array(
                    'articlesRecent' => $articlesRecent,
                    'mapage' => $page,
                    'nombrePage' => ceil(count($articlesRecent) / $nombreArticleParPage)));
    }

    public function voirAction($slugTitre) {
        $article = $this->getDoctrine()
                ->getManager()
                ->getRepository('florianBlogBundle:Article')
                ->myFindOneSlugTitre($slugTitre);
        // Ici, on récupérera l'article correspondant à l'id $id
        $this->get('session')->getFlashBag()->add('info', 'Bonne lecture :)');
        return $this->render('florianBlogBundle:Blog:voir.html.twig', array(
                    'slugTitre' => $slugTitre, "article" => $article
        ));
    }

    public function ajouterAction() {
        // La gestion d'un formulaire est particulière, mais l'idée est la suivante :
        $article = new Article();

        $form = $this->createForm($this->get('form.type.article'), $article);

        $request = $this->get('request');


        if ($request->getMethod() == 'POST') {
            //On hydrate notre formulaire avec les données que l'on a reçu
            $form->bind($request);

            if ($form->isValid()) {
                //On récupère l'utilistaeur en cours
                $user = $this->getUser();

                //On persist alors notre entité hydratée par le formulaire
                $entity_manager = $this->getDoctrine()->getManager();

                //On récupère le service de management des utilisateur du FOSUB
                $userManager = $this->get('fos_user.user_manager');


                //On ajoute notre article à notre utilisateur qui en son sein, va ajouter l'utilisateur à l'article
                $user->addArticle($article);
                $userManager->updateUser($user);

                $entity_manager->flush();
                $this->get('session')->getFlashBag()->add('info', 'Article bien enregistré');

                // Puis on redirige vers la page de visualisation de cet article
                return $this->redirect($this->generateUrl('florian_blog_voir_article', array('slugTitre' => $article->getSlugTitre())));
            }
        }

        // Si on n'est pas en POST, alors on affiche le formulaire
        return $this->render('florianBlogBundle:Blog:ajouter.html.twig', array('form' => $form->createView()));
    }

    public function modifierAction($id) {
        // Ici, on récupérera l'article correspondant à $id
        // Ici, on s'occupera de la création et de la gestion du formulaire

        return $this->render('florianBlogBundle:Blog:modifier.html.twig');
    }

    public function supprimerAction($id) {
        // Ici, on récupérera l'article correspondant à $id
        // Ici, on gérera la suppression de l'article en question

        return $this->render('florianBlogBundle:Blog:supprimer.html.twig');
    }

}
