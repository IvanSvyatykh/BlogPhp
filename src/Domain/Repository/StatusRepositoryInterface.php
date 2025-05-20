<?php


namespace Pri301\Blog\Domain\Repository;


interface StatusRepositoryInterface{

    public function getPublishStatusId(): ?int;
    public function getPendingStatusId(): ?int;
    public function getRejectedStatusId(): ?int;
}