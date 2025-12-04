<?php declare(strict_types=1);

namespace App\Entity;

use A2lix\AutoFormBundle\Form\Attribute\AutoTypeCustom;
use A2lix\TranslationFormBundle\Helper\OneLocaleInterface;
use A2lix\TranslationFormBundle\Helper\OneLocaleTrait;
use App\Entity\Common\IdTrait;
use App\Repository\CompanyMediaLocalizeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyMediaLocalizeRepository::class)]
class CompanyMediaLocalize implements \Stringable, OneLocaleInterface
{
    use IdTrait;
    use OneLocaleTrait;

    #[ORM\Column]
    public ?string $url;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'medias')]
    #[AutoTypeCustom(excluded: true)]
    public ?Company $company = null;

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
