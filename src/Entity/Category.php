<?php declare(strict_types=1);

namespace App\Entity;

use A2lix\AutoFormBundle\Form\Attribute\AutoTypeCustom;
use A2lix\TranslationFormBundle\Helper\KnpTranslatableAccessorTrait;
use App\Entity\Common\IdTrait;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category implements \Stringable, TranslatableInterface
{
    use IdTrait;
    use KnpTranslatableAccessorTrait;
    use TranslatableTrait;

    #[ORM\Column]
    public string $code;

    #[ORM\Column(type: Types::JSON)]
    #[AutoTypeCustom(options: ['entry_options' => ['label' => false]], embedded: true)]
    public array $tags = [];

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'categories')]
    #[AutoTypeCustom(excluded: true)]
    public ?Company $company = null;

    public function addTag(string $tag): self
    {
        if (!\in_array($tag, $this->tags, true)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(string $tag): self
    {
        $this->tags = array_filter($this->tags, static fn (string $t): bool => $t !== $tag);

        return $this;
    }

    public function __toString(): string
    {
        return $this->code;
    }
}
