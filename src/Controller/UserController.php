<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ConnectionType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_index", methods="GET")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/connection", name="user_connection", methods="GET|POST")
     */
    public function connection(Request $request, Session $session): Response
    {
        $form = $this->createForm(ConnectionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneByEmail($data['email']);
            if (!$user) {
                $this->addFlash('danger', 'Cet email n\'est pas enregistré dans la base de données');
                return $this->redirectToRoute('user_connection');
            }

            if ($user->getPassword() !== md5($data['password'])) {
                $this->addFlash('danger', 'Votre mot de passe est incorrect !');
                return $this->render('user/connection.html.twig', array(
                    'form' => $form->createView(),
                ));
            }
            $session->set('connected', true);
            $session->set('user', $user);
            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/connection.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/disconnection", name="user_disconnection", methods="GET|POST")
     */
    public function disconnection(Session $session)
    {
        $session->clear();

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/account/{user}", name="user_account", methods="GET|POST")
     */
    public function account(User $user)
    {
        return $this->render('user/account.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @Route("/new", name="user_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($em->getRepository(User::class)->findByEmail($user->getEmail())) {
                $this->addFlash('danger', 'Cet email est déjà utilisé');
                return $this->redirectToRoute('user_new');
            }
            $user->setRoles(["ROLE_USER"]);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods="GET")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods="GET|POST")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
