<?php


class NftDto {
    private int $id;
    private string $name;
    private string $subtitle;
    private string $description;
    private string $section1;
    private string $section2;
    private string $section3;
    private ?string $type;
    private ?float $price;
    private ?string $img;
    private ?int $owner_id;

    public function __construct(array $data = []) {
        $this->id = $data[NftModel::ID] ?? 0;
        $this->name = $data[NftModel::NAME] ?? '';
        $this->subtitle = $data[NftModel::SUBTITLE] ?? '';
        $this->description = $data[NftModel::DESCRIPTION] ?? '';
        $this->section1 = $data[NftModel::SECTION1] ?? '';
        $this->section2 = $data[NftModel::SECTION2] ?? '';
        $this->section3 = $data[NftModel::SECTION3] ?? '';
        $this->type = $data[NftModel::TYPE] ?? null;
        $this->price = $data[NftModel::PRICE] ?? null;
        $this->img = $data[NftModel::IMG] ?? null;
        $this->owner_id = $data[NftModel::OWNER_ID] ?? null;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getSubtitle(): string {
        return $this->subtitle;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getSection1(): string {
        return $this->section1;
    }

    public function getSection2(): string {
        return $this->section2;
    }

    public function getSection3(): string {
        return $this->section3;
    }

    public function getType(): ?string {
        return $this->type;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function getImg(): ?string {
        return $this->img;
    }

    public function getOwnerId(): ?int {
        return $this->owner_id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setSubtitle(string $subtitle): void {
        $this->subtitle = $subtitle;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setSection1(string $section1): void {
        $this->section1 = $section1;
    }

    public function setSection2(string $section2): void {
        $this->section2 = $section2;
    }

    public function setSection3(string $section3): void {
        $this->section3 = $section3;
    }

    public function setType(?string $type): void {
        $this->type = $type;
    }

    public function setPrice(?float $price): void {
        $this->price = $price;
    }

    public function setImg(?string $img): void {
        $this->img = $img;
    }

    public function setOwnerId(?int $owner_id): void {
        $this->owner_id = $owner_id;
    }
}