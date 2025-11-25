<?php


class FavoriteDto {
    private int $id;
    private int $nft_id;
    private int $user_id;


    public function __construct(array $data = []) {
        $this->id = $data[FavoriteModel::ID] ?? 0;
        $this->nft_id = $data[FavoriteModel::NFT_ID] ?? 0;
        $this->user_id = $data[FavoriteModel::USER_ID] ?? 0;
    }
}