<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Http\Transformers\UserTransformer;
use Illuminate\Events\Dispatcher;

/**
 * Class UserService
 * @package App\Http\Services
 */
class UserService
{

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * UserService constructor.
     * @param Dispatcher $dispatcher
     * @param UserRepository $userRepository
     * @param UserTransformer $userTransformer
     */
    public function __construct(
        Dispatcher $dispatcher,
        UserRepository $userRepository,
        UserTransformer $userTransformer
    ) {
        $this->dispatcher = $dispatcher;
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $user = $this->userRepository->findOne($id);
        $user = $this->userTransformer->transformItem($user);
        return $user;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        $users = $this->userRepository->findAll();
        $users = $this->userTransformer->transformCollection($users);
        return $users;
    }



    /**
     * @param array $data
     * @return \App\User
     * @throws \Exception
     */
    public function create(array $data)
    {
//        $account = $this->auth->getCurrentUser();

        // Check if the user has permission to create other users.
        // Will throw an exception if not.
//        $account->checkPermission('users.create');

        // Use our validation helper to check if the given email
        // is unique within the account.

        // Set the account ID on the user and create the record in the database
        $user = $this->userRepository->create($data);
        $user = $this->userTransformer->transformItem($user);

        // Fire an event so that listeners can react
//        $this->dispatcher->fire(new UserWasCreated($user));

        return $user;
    }


    /**
     * @param $id
     * @param array $data
     * @return array|mixed
     * @throws \Exception
     */
    public function update($id, array $data)
    {
        $user = $this->userRepository->update($id, $data);
        $user = $this->userTransformer->transformItem($user);
        return $user;
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->userRepository->delete($id);
    }


}