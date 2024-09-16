<?php

declare(strict_types=1);

namespace App\Entity;

use A2lix\TranslationFormBundle\Gedmo\TranslationTrait;
use App\Repository\CompanyTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

#[ORM\Entity(repositoryClass: CompanyTranslationRepository::class)]
#[ORM\UniqueConstraint(columns: ['locale', 'object_id', 'field'])]
class CompanyTranslation extends AbstractPersonalTranslation
{
    use TranslationTrait;

    /** @var Company */
    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'translations')]
    #[ORM\JoinColumn(name: 'object_id', nullable: false, onDelete: 'CASCADE')]
    protected $object;
}
