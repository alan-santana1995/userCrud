<?php

namespace App\Domain\User\DTO;

use App\Domain\User\Requests\GetUsersRequest;

class GetPaginatedUsersParameters
{
    public function __construct(
        private bool $showInactives,
        private int $page,
        private int $pageSize
    ) {
    }

    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getShowInactives(): bool
    {
        return $this->showInactives;
    }

    public static function fromGetUsersRequest(GetUsersRequest $request): self
    {
        $data = $request->validated();
        return new self(
            showInactives: $data['show_inactives'],
            page: $data['page'],
            pageSize: $data['page_size'],
        );
    }
}
