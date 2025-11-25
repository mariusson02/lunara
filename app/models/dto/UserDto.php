<?php

class UserDto {
    private int $id;
    private string $username;
    private string $pass_hash;
    private string $salt;
    private ?string $email;
    private ?string $wallet;
    private int $role_id;

    public function __construct(array $data = []) {
        $this->id = $data[UserModel::ID] ?? 0;
        $this->username = $data[UserModel::USERNAME] ?? '';
        $this->pass_hash = $data[UserModel::PASS_HASH] ?? '';
        $this->salt = $data[UserModel::SALT] ?? '';
        $this->email = $data[UserModel::EMAIL] ?? null;
        $this->wallet = $data[UserModel::WALLET] ?? null;
        $this->role_id = $data[UserModel::ROLE_ID] ?? 0;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }

    public function getPassHash(): string {
        return $this->pass_hash;
    }

    public function setPassHash(string $pass_hash): void {
        $this->pass_hash = $pass_hash;
    }

    public function getSalt(): string {
        return $this->salt;
    }

    public function setSalt(string $salt): void {
        $this->salt = $salt;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): void {
        $this->email = $email;
    }

    public function getWallet(): ?string {
        return $this->wallet;
    }

    public function setWallet(?string $wallet): void {
        $this->wallet = $wallet;
    }

    public function getRoleId(): int {
        return $this->role_id;
    }

    public function setRoleId(int $role_id): void {
        $this->role_id = $role_id;
    }
}