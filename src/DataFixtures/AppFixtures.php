<?php

namespace App\DataFixtures;

use App\Entity\Grade;
use App\Entity\Promotion;
use App\Entity\Student;
use App\Entity\Subject;
use App\Entity\SupportWorker;
use App\Entity\User;
use DateInterval;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $adminName = [
            'Nicolas',
            'Karine',
            'Alexis',
            'Pierrick',
        ];

        for ($i = 0; $i < 4; $i++) {
            $user = new User;
            $user->setEmail($adminName[$i] . '@admin.com');
            $password = $this->passwordHasher->hashPassword($user, 'password');
            $user->setPassword($password);
            $user->setRoles([
                'ROLE_ADMIN'
            ]);
            // $user->setApiKey(md5(random_bytes(16)));

            $manager->persist($user);
        }

        $list_of_promotions = [];
        for ($i = 0; $i < 5; $i++) {
            $promotion = new Promotion();
            $promotion->setName('A' . $i);
            $promotion->setDateOfRelease('202' . $i);

            $manager->persist($promotion);
            $list_of_promotions[] = $promotion;
        }

        $manager->flush();

        $promoRepo = $manager->getRepository(Promotion::class);
        $allPromo = $promoRepo->findAll();

        $list_of_student = [];
        for ($i = 0; $i < 10; $i++) {
            $randKey = rand(0, count($allPromo) - 1);

            $student = new Student();
            $student->setFirstName('studentFirstName' . $i);
            $student->setLastName('studentLastName' . $i);
            $student->setAge(20);
            $student->setDateOfArrival('2022');
            $student->setIdPromotion($allPromo[$randKey]);

            $list_of_student[] = $student;
            $manager->persist($student);
        }

        $manager->flush();

        for ($i = 0; $i < 5; $i++) {
            $supportWorker = new SupportWorker();
            $supportWorker->setFirstName('SWFirstName' . $i);
            $supportWorker->setLastName('SWLastName' . $i);
            $supportWorker->setDateOfArrival('20' . rand(10, 18));

            $manager->persist($supportWorker);
        }

        $manager->flush();

        $SWRepo = $manager->getRepository(SupportWorker::class);
        $allSW = $SWRepo->findAll();

        for ($i = 0; $i < 10; $i++) {
            $dateStart = new DateTime();
            $dateEnd = DateTime::createFromInterface($dateStart)->add(new DateInterval('P1D'));

            $randKey1 = rand(0, count($allPromo) - 1);
            $randKey2 = rand(0, count($allSW) - 1);

            $subject = new Subject();
            $subject->setName('Subject' . $i);
            $subject->setDateOfStart($dateStart);
            $subject->setDateOfEnd($dateEnd);
            $subject->setIdPromotion($allPromo[$randKey1]);
            $subject->setIdSupportWorker($allSW[$randKey2]);


            $manager->persist($subject);
        }

        $manager->flush();

        $studentRepo = $manager->getRepository(Student::class);
        $allStudent = $studentRepo->findAll();

        $subjectRepo = $manager->getRepository(Subject::class);
        $allSubject = $subjectRepo->findAll();

        foreach ($allStudent as $student) {
            for ($i = 0; $i < count($allStudent); $i++) {
                $randKey3 = rand(0, count($allSubject) - 1);

                $grade = new Grade();
                $grade->setGrade(rand(0, 20));
                $grade->setIdSubject($allSubject[$randKey3]);
                $grade->setIdStudent($student);

                $manager->persist($grade);
            }
        }

        $manager->flush();
    }
}
