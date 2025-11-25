<?php


class TransactionDto {
    private int $id;
    private string $timestamp;
    private int $nft_id;
    private int $user_id;

    public function __construct(array $data = []) {
        $this->id = $data[TransactionModel::ID] ?? 0;
        $this->timestamp = $data[TransactionModel::TIMESTAMP] ?? date('Y-m-d H:i:s');
        $this->nft_id = $data[TransactionModel::NFT_ID] ?? 0;
        $this->user_id = $data[TransactionModel::USER_ID] ?? 0;
    }
}