<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectsController extends AbstractController
{
    // ---------------------------
    // PUBLIC LIST
    // ---------------------------

    #[Route('/projects', name: 'app_projects')]
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findBy([], ['position' => 'ASC']);

        return $this->render('projects.html.twig', [
            'metatitle'  => 'Carlos Andreu Gasca | Proyectos',
            'body_class' => 'd-flex flex-column h-100 bg-light',
            'projects'   => $projects
        ]);
    }

    // ---------------------------
    // ADMIN LIST
    // ---------------------------

    #[Route('/admin/projects', name: 'admin_projects')]
    public function adminIndex(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findBy([], ['position' => 'ASC']);

        return $this->render('/admin/admin_projects_list.html.twig', [
            'projects' => $projects,
            'metatitle' => 'Administrar proyectos',
            'body_class' => 'bg-light'
        ]);
    }

    // ---------------------------
    // ADMIN CREATE
    // ---------------------------

    #[Route('/admin/projects/new', name: 'admin_projects_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, ProjectRepository $projectRepository): Response
    {
        $project = new Project();
        $project->setCreatedAt(new \DateTimeImmutable());

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $last = $projectRepository->findOneBy([], ['position' => 'DESC']);
            $project->setPosition($last ? $last->getPosition() + 1 : 1);

            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('kernel.project_dir').'/public/uploads',
                    $newFilename
                );

                $project->setImage($newFilename);
            }

            $entityManager->persist($project);
            $entityManager->flush();

            $this->addFlash('success', 'Proyecto creado correctamente.');

            return $this->redirectToRoute('admin_projects');
        }

        return $this->render('/admin/admin_projects_form.html.twig', [
            'form' => $form->createView(),
            'metatitle' => 'Nuevo proyecto',
            'body_class' => 'bg-light'
        ]);
    }

    // ---------------------------
    // ADMIN EDIT
    // ---------------------------

    #[Route('/admin/projects/{id}/edit', name: 'admin_projects_edit')]
    public function edit(Project $project, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('kernel.project_dir').'/public/uploads',
                    $newFilename
                );

                $project->setImage($newFilename);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Proyecto actualizado correctamente.');

            return $this->redirectToRoute('admin_projects');
        }

        return $this->render('/admin/admin_projects_form.html.twig', [
            'form' => $form->createView(),
            'metatitle' => 'Editar proyecto',
            'body_class' => 'bg-light'
        ]);
    }

    // ---------------------------
    // ADMIN DELETE
    // ---------------------------

    #[Route('/admin/projects/{id}/delete', name: 'admin_projects_delete', methods: ['POST'])]
    public function delete(Project $project, Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {

            $entityManager->remove($project);
            $entityManager->flush();

            $this->addFlash('success', 'Proyecto eliminado correctamente.');
        }

        return $this->redirectToRoute('admin_projects');
    }

    #[Route('/admin', name: 'admin_dashboard')]
    public function adminDashboard(): Response
    {
        return $this->redirectToRoute('admin_projects');
    }

    #[Route('/admin/projects/reorder', name: 'admin_projects_reorder', methods: ['POST'])]
    public function reorder(Request $request, ProjectRepository $repo, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        foreach ($data as $item) {

            $project = $repo->find($item['id']);

            if ($project) {
                $project->setPosition($item['position']);
            }
        }

        $em->flush();

        return new Response('ok');
    }

}