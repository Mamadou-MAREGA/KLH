<?php

namespace App\Controller;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecetteController extends AbstractController
{

    private $recetteRepository;

    public function __construct(RecetteRepository $recetteRepository)
    {
        $this->recetteRepository = $recetteRepository;
    }


    /**
     * @Route("/recette/add", name="add_recette", methods={"POST"})
     */
    public function add(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $title  = $data['title'];
        $soustitres = $data['soustitres'];
        $ingredient = $data['ingredient'];

        
        if(empty($title) || empty($soustitres) || empty($ingredient))
        {
            throw new NotFoundHttpException('Les parametres sont obligatoires !');
        }

        $this->recetteRepository->saveRecette($title, $soustitres, $ingredient);

        return new JsonResponse(['status' => 'Recette créee !'], Response::HTTP_CREATED);
        
    }

    /**
    * @Route("/recette/{id}", name="get_one_recette", methods={"GET"})
    */
    public function getOneRecette($id)
    {
        $recette = $this->recetteRepository->findOneBy(['id' => $id]);

        $data = [

            'id' => $recette->getId(), 
            'title' => $recette->getTitle(),
            'soustitres' => $recette->getSoustitres(),
            'ingredient' => $recette->getIngredient()

        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
    * @Route("/recettes", name="get_all_recette", methods={"GET"})
    */

    public function getAllRecette()
    {
        $recettes = $this->recetteRepository->findAll();

        $data = [] ;

        foreach ($recettes as $recette) {
            
           $data[] = [

                'id' => $recette->getId(),
                'title' => $recette->getTitle(),
                'soustitres' => $recette->getSoustitres(),
                'ingredient' => $recette->getingredient()

           ];

        }

        return new JsonResponse($data, Response::HTTP_OK);
    }


    /**
    * @Route("/recettes/{id}", name="update_recette", methods={"PUT"})
    */
    public function update($id, Request $request)
    {
        $recette = $this->recetteRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        // dd($data);

        // empty($data(['title']) ? true : $recette->setTitle($data['title']));
        // empty($data(['soustitres']) ? true : $recette->setTitle($data['soustitres']));
        // empty($data(['ingredient']) ? true : $recette->setTitle($data['ingredient']));

        $recette->setTitle($data['title']);
        $recette->setSoustitres($data['soustitres']);
        $recette->setIngredient($data['ingredient']);
        $recetteUpdate = $this->recetteRepository->updateRecette($recette);

        return new JsonResponse($recetteUpdate->toArray(), Response::HTTP_OK);
    }
    
    /**
    * @Route("/recettes/{id}", name="delete_recette", methods={"DELETE"})
    */
    public function delete($id)
    {
        $recette = $this->recetteRepository->findOneBy(['id' => $id]);
        $this->recetteRepository->removeRecette($recette);

        return new JsonResponse(['status' => 'Recette deleted'], Response::HTTP_NO_CONTENT);
    }


}
