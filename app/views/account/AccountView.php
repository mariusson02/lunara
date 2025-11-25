<?php

class AccountView extends View {

    private array $user = [];
    private array $myNfts = [];
    private array $transactions = [];
    private array $favorites = [];
    public function __construct()
    {
        parent::__construct('account');
    }

    public function setUser(array $user): void {
        $this->user = $user;
    }
    public function getUser() : array {
        return $this->user;
    }

    public function setMyNfts(array $myNfts): void {
        $this->myNfts = $myNfts;
    }
    public function getMyNfts() : array {
        return $this->myNfts;
    }

    public function setTransactions(array $transactions): void {
        $this->transactions = $transactions;
    }
    public function getTransactions() : array {
        return $this->transactions;
    }

    public function setFavorites(array $favorites): void {
        $this->favorites = $favorites;
    }
    public function getFavorites() : array {
        return $this->favorites;
    }
}