<?php declare(strict_types=1);

namespace App\Entity;

use A2lix\AutoFormBundle\Form\Attribute\AutoTypeCustom;
use A2lix\TranslationFormBundle\Helper\OneLocaleInterface;
use A2lix\TranslationFormBundle\Helper\OneLocaleTrait;
use App\Entity\Common\IdTrait;
use App\Repository\CompanyMediaLocaleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyMediaLocaleRepository::class)]
class CompanyMediaLocale implements \Stringable, OneLocaleInterface
{
    use IdTrait;
    use OneLocaleTrait;

    #[ORM\Column]
    #[Assert\NotBlank]
    public ?string $url = null;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'medias')]
    #[AutoTypeCustom(excluded: true)]
    public ?Company $company;

    public function isEmpty(): bool
    {
        return null === $this->url;
    }

    public function __toString(): string
    {
        return \sprintf(
            '%s',
            $this->url,
        );
    }
}
