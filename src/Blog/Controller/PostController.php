<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/15/14
 * Time: 12:49 PM
 */

namespace Blog\Controller;

use Blog\Model\Post;
use Framework\Controller\Controller;
use Framework\DI\Service;
use Framework\Exception\DatabaseException;
use Framework\Exception\HttpNotFoundException;
use Framework\Request\Request;
use Framework\Response\Response;
use Framework\Validation\Validator;

class PostController extends Controller
{

    /**
     * @Route("posts", "/posts")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('index.html', array('posts' => Post::getRepository()->findAll()));
    }

    /**
     * @Route("post", "/post/{id}", {id: "\d+"})
     *
     * @param $id
     * @return Response
     */

    public function getPostAction($id)
    {
        return new Response('Post: #'.$id);
    }

    public function addAction()
    {
        if ($this->getRequest()->isPost()) {
            try{
                $post          = new Post();
                $date          = new \DateTime();
                $post->setTitle($this->getRequest()->post('title'));
                $post->setContent(trim($this->getRequest()->post('content')));
                $post->setDate($date);

                if ($post->persist()) {
                    $post->flush();
                    return $this->redirect($this->generateRoute('home'), 'The data has been saved successfully');
                } else {
                    $error = $post->getErrors();
                }
            } catch(DatabaseException $e){
                $error = $e->getMessage();
            }
        }

        return $this->render(
                    'add.html',
                    array('action' => $this->generateRoute('add_post'), 'errors' => isset($error)?$error:null, 'post' => new Post())
        );
    }

    public function showAction($id)
    {
        if (!$post = Post::findOne((int)$id)) {
            throw new HttpNotFoundException('Page Not Found!');
        }
        return $this->render('show.html', array('post' => $post));
    }
}