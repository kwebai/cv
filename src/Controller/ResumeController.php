<?php
namespace App\Controller;

use App\Entity\Experience;
use App\Form\ExperienceType;
use App\Repository\ExperienceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Education;
use App\Form\EducationType;
use App\Repository\EducationRepository;

use App\Entity\Skill;
use App\Form\SkillType;
use App\Repository\SkillRepository;

use App\Entity\Language;
use App\Form\LanguageType;
use App\Repository\LanguageRepository;


final class ResumeController extends AbstractController
{


    #[Route('/resume', name: 'app_resume')]
    public function index(
        ExperienceRepository $repo,
        EducationRepository $educationRepo,
        SkillRepository $skillRepo,
        LanguageRepository $languageRepo
    ): Response
    {
        $experiences = $repo->findBy([], ['startDate' => 'DESC']);
        $educations  = $educationRepo->findBy([], ['startYear' => 'DESC']);
        $skills     = $skillRepo->findBy([], ['ord' => 'ASC']);
        $languages  = $languageRepo->findBy([], ['name' => 'ASC']);

        return $this->render('resume.html.twig', [
            'metatitle'     => 'Carlos Andreu Gasca | Resume',
            'body_class'    => 'd-flex flex-column h-100 bg-light',
            'experiences'   => $experiences,
            'educations'    => $educations,
            'skills'        => $skills,
            'languages'     => $languages
        ]);
    }

    #[Route('/admin/experience', name: 'admin_experience')]
    public function adminIndex(ExperienceRepository $repo): Response
    {
        return $this->render('admin/experience_list.html.twig', [
            'experiences' => $repo->findAll()
        ]);
    }

    #[Route('/admin/experience/new', name: 'admin_experience_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $experience = new Experience();

        $form = $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($experience);
            $em->flush();

            return $this->redirectToRoute('admin_experience');
        }

        return $this->render('admin/experience_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/experience/{id}/edit', name: 'admin_experience_edit')]
    public function edit(
        Experience $experience,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $form = $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('admin_experience');
        }

        return $this->render('admin/experience_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/experience/{id}/delete', name: 'admin_experience_delete', methods:['POST'])]
    public function delete(
        Experience $experience,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        if ($this->isCsrfTokenValid('delete'.$experience->getId(), $request->request->get('_token'))) {

            $em->remove($experience);
            $em->flush();
        }

        return $this->redirectToRoute('admin_experience');
    }



    #[Route('/admin/education', name: 'admin_education')]
    public function adminEducation(EducationRepository $repo): Response
    {
        return $this->render('admin/education_list.html.twig', [
            'education' => $repo->findBy([], ['startYear' => 'DESC'])
        ]);
    }
    #[Route('/admin/education/new', name: 'admin_education_new')]
    public function newEducation(Request $request, EntityManagerInterface $em): Response
    {
        $education = new Education();

        $form = $this->createForm(EducationType::class, $education);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($education);
            $em->flush();

            return $this->redirectToRoute('admin_education');
        }

        return $this->render('admin/education_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/education/{id}/edit', name: 'admin_education_edit')]
    public function editEducation(
        Education $education,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $form = $this->createForm(EducationType::class, $education);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('admin_education');
        }

        return $this->render('admin/education_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/education/{id}/delete', name: 'admin_education_delete', methods:['POST'])]
    public function deleteEducation(
        Education $education,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        if ($this->isCsrfTokenValid('delete'.$education->getId(), $request->request->get('_token'))) {

            $em->remove($education);
            $em->flush();
        }

        return $this->redirectToRoute('admin_education');
    }




    #[Route('/admin/skill', name: 'admin_skill')]
    public function adminSkill(SkillRepository $repo): Response
    {
        return $this->render('admin/skill_list.html.twig', [
            'skill' => $repo->findBy([], ['ord' => 'ASC'])
        ]);
    }
    
    #[Route('/admin/skill/new', name: 'admin_skill_new')]
    public function newSkill(Request $request, EntityManagerInterface $em): Response
    {
        $skill = new Skill();

        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $last = $skillRepository->findOneBy([], ['ord' => 'DESC']);
            $skill->setOrd($last ? $last->getOrd() + 1 : 1);

            $em->persist($skill);
            $em->flush();

            return $this->redirectToRoute('admin_skill');
        }

        return $this->render('admin/skill_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/skill/{id}/edit', name: 'admin_skill_edit')]
    public function editSkill(
        Skill $skill,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('admin_skill');
        }

        return $this->render('admin/skill_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/skill/{id}/delete', name: 'admin_skill_delete', methods:['POST'])]
    public function deleteSkill(
        Skill $skill,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->request->get('_token'))) {

            $em->remove($skill);
            $em->flush();
        }

        return $this->redirectToRoute('admin_skill');

    }

    #[Route('/admin/skills/reorder', name: 'admin_skills_reorder', methods: ['POST'])]
    public function reorder(Request $request, SkillRepository $skillRepo, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        foreach ($data as $item) {

            $skill = $skillRepo->find($item['id']);

            if ($skill) {
                $skill->setOrd($item['position']);
            }
        }

        $em->flush();

        return new Response('ok');
    }






    #[Route('/admin/language', name: 'admin_language')]
    public function adminLanguage(LanguageRepository $repo): Response
    {
        return $this->render('admin/language_list.html.twig', [
            'language' => $repo->findBy([], ['name' => 'ASC'])
        ]);
    }
    #[Route('/admin/language/new', name: 'admin_language_new')]
    public function newLanguage(Request $request, EntityManagerInterface $em): Response
    {
        $language = new Language();

        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($language);
            $em->flush();

            return $this->redirectToRoute('admin_language');
        }

        return $this->render('admin/language_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/language/{id}/edit', name: 'admin_language_edit')]
    public function editLanguage(
        Language $language,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('admin_language');
        }

        return $this->render('admin/language_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/language/{id}/delete', name: 'admin_language_delete', methods:['POST'])]
    public function deleteLanguage(
        Language $language,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        if ($this->isCsrfTokenValid('delete'.$language->getId(), $request->request->get('_token'))) {

            $em->remove($language);
            $em->flush();
        }

        return $this->redirectToRoute('admin_language');
    }






}