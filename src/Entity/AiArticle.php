<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\State\AiArticleProcessor;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Component\Uid\Uuid;

/** AI generated Article */
#[ApiResource(shortName: "AiArticle",
    description: "This Endpoint works with the base Article to generate AI Articles",
    operations: [
        new Post(stateless: false, processor: AiArticleProcessor::class),
    ],
    formats: ['json', 'html']
)]
#[ORM\Entity]
class AiArticle
{
    /**
     * @var Uuid $id
     * the ID for the created AI Article
     */
    #[
        ORM\Id,
        ORM\Column(type:"uuid", unique:true),
        ORM\GeneratedValue(strategy:"CUSTOM"),
        ORM\CustomIdGenerator(class:UuidGenerator::class)
    ]
    private Uuid $id;

    /**
     * @var string $locale
     * Language of the generated Text for multilingual extension default Germany
     */
    #[ORM\Column(type: "string")]
    private string $locale = "de";

    /**
     * @var string $text
     * Ai Generated Text Body
     */
    #[ORM\Column(type: "text")]
    private string $text;

    #[ORM\Column(type: "text")]
    private string $prompt;

    #[ORM\Column(type: "integer")]
    private int $quantity;

    #[ORM\Column(type: "string")]
    private string $tenant;

    /**
     * @var DateTime $createdAt
     * The creation Date
     */
    #[ORM\Column(type: "datetime")]
    private DateTime $createdAt;

    #[ORM\Column(type: 'string')]
    private string $parentUuid;

    /**
     * AI Article constructor.
     */
    public function __construct() {
        $this->locale = "de";
        $this->createdAt = new DateTime('now');
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getTenant(): string
    {
        return $this->tenant;
    }

    public function setTenant(string $tenant): void
    {
        $this->tenant = $tenant;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getPrompt(): string
    {
        return $this->prompt;
    }

    public function setPrompt(string $prompt): void
    {
        $this->prompt = $prompt;
    }

    public function getParentUuid(): string
    {
        return $this->parentUuid;
    }

    public function setParentUuid(string $parentUuid): void
    {
        $this->parentUuid = $parentUuid;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

}