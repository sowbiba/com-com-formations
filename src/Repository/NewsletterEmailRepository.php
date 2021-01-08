<?php

namespace App\Repository;

use App\Entity\NewsletterEmail;

/**
 * @method NewsletterEmail|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterEmail|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterEmail[]    findAll()
 * @method NewsletterEmail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterEmailRepository extends AbstractRepository
{
    protected $entityClass = NewsletterEmail::class;
    protected $tableAlias = 'newsletterEmails';
}