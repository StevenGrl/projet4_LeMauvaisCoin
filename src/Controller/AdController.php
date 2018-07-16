<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ad")
 */
class AdController extends Controller
{
    /**
     * @Route("/", name="ad_index", methods="GET")
     */
    public function index(AdRepository $adRepository): Response
    {
        return $this->render('ad/index.html.twig', ['ads' => $adRepository->findAll()]);
    }

    /**
     * @Route("/mine", name="ad_mine", methods="GET")
     */
    public function mine(AdRepository $adRepository): Response
    {
        if ($this->getUser()) {
            return $this->render('ad/mine.html.twig', ['ads' => $adRepository->findByCreator($this->getUser()->getId())]);
        }
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/new", name="ad_new", methods="GET|POST")
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $ad->getImageFile();
            $fileName = $fileUploader->upload($file);
            $ad->setImageFile($file);
            $ad->setImage($fileName);
            $em = $this->getDoctrine()->getManager();
            $ad->setCreatedAt(new \DateTime());
            $ad->setUpdatedAt(new \DateTime());
            $ad->setCreator($this->getUser());
            $em->persist($ad);
            $em->flush();

            return $this->redirectToRoute('ad_index');
        }

        return $this->render('ad/new.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ad_show", methods="GET")
     */
    public function show(Ad $ad): Response
    {
        return $this->render('ad/show.html.twig', ['ad' => $ad]);
    }

    /**
     * @Route("/{id}/edit", name="ad_edit", methods="GET|POST")
     */
    public function edit(Request $request, Ad $ad): Response
    {
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ad_edit', ['id' => $ad->getId()]);
        }

        return $this->render('ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ad_delete", methods="DELETE")
     */
    public function delete(Request $request, Ad $ad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ad->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ad);
            $em->flush();
        }

        return $this->redirectToRoute('ad_index');
    }
}
