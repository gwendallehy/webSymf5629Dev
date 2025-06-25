<?php

namespace App\Repository;

use App\Entity\ResetPasswordRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use SymfonyCasts\Bundle\ResetPassword\Model\ResetPasswordRequestInterface;
use SymfonyCasts\Bundle\ResetPassword\Persistence\ResetPasswordRequestRepositoryInterface;

/**
 * @method void removeRequests(object $user)
 */
class ResetPasswordRequestRepository extends ServiceEntityRepository implements ResetPasswordRequestRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResetPasswordRequest::class);
    }

    // Méthodes requises par ResetPasswordRequestRepositoryInterface
    public function createResetPasswordRequest(object $user, \DateTimeInterface $expiresAt, string $selector, string $hashedToken): ResetPasswordRequest
    {
        return new ResetPasswordRequest($user, $expiresAt, $selector, $hashedToken);
    }

    public function findOneBySelector(string $selector): ?ResetPasswordRequest
    {
        return $this->findOneBy(['selector' => $selector]);
    }

    public function removeResetPasswordRequest(ResetPasswordRequestInterface $resetPasswordRequest): void
    {
        $this->getEntityManager()->remove($resetPasswordRequest);
        $this->getEntityManager()->flush();
    }

    public function removeResetPasswordRequests(object $user): void
    {
        $requests = $this->findBy(['user' => $user]);

        foreach ($requests as $request) {
            $this->getEntityManager()->remove($request);
        }

        $this->getEntityManager()->flush();
    }

    public function getUserIdentifier(object $user): string
    {
        // En général, retourne un identifiant unique, comme l'email
        return $user->getEmail();
    }

    public function persistResetPasswordRequest(ResetPasswordRequestInterface $resetPasswordRequest): void
    {
        $this->getEntityManager()->persist($resetPasswordRequest);
        $this->getEntityManager()->flush();
    }

    public function findResetPasswordRequest(string $selector): ?ResetPasswordRequestInterface
    {
        return $this->findOneBy(['selector' => $selector]);
    }

    /**
     * @throws \Exception
     */
    public function getMostRecentNonExpiredRequestDate(object $user): ?\DateTimeInterface
    {
        $qb = $this->createQueryBuilder('r')
            ->select('MAX(r.expiresAt) as maxDate')
            ->where('r.user = :user')
            ->andWhere('r.expiresAt > :now')
            ->setParameter('user', $user)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getSingleScalarResult();

        return $qb ? new \DateTime($qb) : null;
    }


    public function removeExpiredResetPasswordRequests(): int
    {
        $qb = $this->getEntityManager()->createQueryBuilder()
            ->delete(ResetPasswordRequest::class, 'r')
            ->where('r.expiresAt <= :now')
            ->setParameter('now', new \DateTime())
            ->getQuery();

        return $qb->execute();
    }
}
