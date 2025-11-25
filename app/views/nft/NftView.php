<?php

class NftView extends View {

    private mixed $nft = [];

    public function __construct() {
        parent::__construct('nft');
    }

    public function setNft(mixed $nft) : void
    {
        $this->nft = $nft;
    }
    public function getNft() {
        return $this->nft;
    }
}