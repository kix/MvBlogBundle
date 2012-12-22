<?php

namespace Mv\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Mv\BlogBundle\Entity\AdminBlog\Category;
use Mv\BlogBundle\Entity\AdminBlog\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Mv\BlogBundle\Entity\AdminBlog\PostRepository;

/**
 * DefaultController controller.
 *
 * @Route("/blog")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="blog_homepage")
     * @Template()
     */
    public function homepageAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MvBlogBundle:AdminBlog\Post')->findAllPubliedOrdered();
        
        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * @Route("/category/{id}", name="blog_category_list")
     * @Template()
     */
    public function categoryAction(Category $category)
    {        
        $entities = new ArrayCollection( $category->getPosts()->toArray() );
        
        return array(
            'category' => $category,
            'entities' => $entities->matching(PostRepository::getPubliedOrderedCriteria())->toArray(),
        );
    }
    
    /**
     * @Template()
     */
    public function menuAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MvBlogBundle:AdminBlog\Category')->findAll();
        
        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Blog\Post entity.
     *
     * @Route("/article/{id}", name="blog_post_show")
     * @Method("GET")
     * @Template()
     */
    public function showArticleAction(Post $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }
}