<?php

namespace App\Providers;

use App\Interfaces\IBookCopyRepository;
use App\Interfaces\IBookRepository;
use App\Interfaces\IBranchRepository;
use App\Interfaces\IReservationRepository;
use App\Interfaces\IUserRepository;
use App\Repositories\BookCopyRepository;
use App\Repositories\BookRepository;
use App\Repositories\BranchRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppRepositoriesProvider extends ServiceProvider
{
    protected array $repositoryBindings = [
        IUserRepository::class => UserRepository::class,
        IBookRepository::class => BookRepository::class,
        IBranchRepository::class => BranchRepository::class,
        IBookCopyRepository::class => BookCopyRepository::class,
        IReservationRepository::class => ReservationRepository::class,
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        foreach ($this->repositoryBindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
