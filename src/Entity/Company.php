<?php

declare(strict_types=1);

namespace App\Entity;

use A2lix\AutoFormBundle\Form\Attribute\AutoTypeCustom;
use A2lix\TranslationFormBundle\Form\Type\TranslationsFormsType;
use App\Entity\Common\IdTrait;
use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use A2lix\TranslationFormBundle\Helper\KnpTranslatableAccessorTrait;
use App\Form\CompanyMediaType;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company implements TranslatableInterface
{
    use IdTrait;
    use TranslatableTrait;
    use KnpTranslatableAccessorTrait;

    #[ORM\Column]
    #[AutoTypeCustom(options: ['priority' => 2])]
    public string $code;

    #[AutoTypeCustom(options: ['priority' => 1])]
    protected $translations;

    /** @var Collection<int, Category> */
    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'company', cascade: ['all'], orphanRemoval: true)]
    #[AutoTypeCustom(embedded: true, options: ['entry_options' => ['label' => false]])]
    public Collection $categories;

    /** @var Collection<int, CompanyMediaLocalize> */
    #[ORM\OneToMany(targetEntity: CompanyMediaLocalize::class, mappedBy: 'company', indexBy: 'locale', cascade: ['all'], orphanRemoval: true)]
    // #[AutoTypeCustom(embedded: true, options: ['entry_options' => ['label' => false, 'children_excluded' => ['id']]])]
    #[AutoTypeCustom(type: TranslationsFormsType::class, options: ['form_type' => CompanyMediaType::class])]
    public Collection $medias;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->medias = new ArrayCollection();
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $category->company = $this;
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function addMedia(CompanyMediaLocalize $media): self
    {
        if (!$this->medias->contains($media)) {
            $media->company = $this;
            $this->medias[] = $media;
        }

        return $this;
    }

    public function removeMedia(CompanyMediaLocalize $media): self
    {
        $this->medias->removeElement($media);

        return $this;
    }

    public function getMediaLocalized(): ?CompanyMediaLocalize
    {
        $currLocale = $this->getCurrentLocale();
        $mediaLocalized = $this->medias->filter(static fn(CompanyMediaLocalize $media): bool => $media->locale === $currLocale);

        return $mediaLocalized->first() ?: null;
    }
}
