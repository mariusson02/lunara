<?php

class AdminView extends View {

    private array $user = [];
    private array $users = [];
    private array $transactions = [];
    private array $nfts = [];
    public function __construct()
    {
        parent::__construct('admin');
    }

    public function setUser(array $user): void {
        $this->user = $user;
    }
    public function getUser() : array {
        return $this->user;
    }

    public function setUsers(array $users): void {
        $this->users = $users;
    }
    public function getUsers() : array {
        return $this->users;
    }

    public function setTransactions(array $transactions): void {
        $this->transactions = $transactions;
    }
    public function getTransactions() : array {
        return $this->transactions;
    }

    public function getNfts(): array {
        return $this->nfts;
    }

    public function setNfts(array $nfts): void {
        $this->nfts = $nfts;
    }
}