<?php
/**
 * User: kishan
 * Date: 9/20/14
 * Time: 1:33 PM
 */

namespace Karma\Registration;


use Karma\Users\IndUserRepository;
use Karma\Users\IndUser;

class IndFacebookRegister implements IndUserRegisterInterface
{


    /**
     * @var \Karma\Users\IndUserRepository
     */
    private $indUserRepository;
    /**
     * @var \Karma\Users\IndUser
     */
    private $indUser;

    public function __construct(IndUserRepository $indUserRepository, IndUser $indUser)
    {
        $this->indUserRepository = $indUserRepository;
        $this->indUser = $indUser;
    }

    public function register($post)
    {

        $user = $this->indUser->register(
            '1',
            '1',
            '1',
            'Kishan',
            'Mainali',
            'mainalikishan@gmail.com',
            \Hash::make('123456'),
            '1989-01-22',
            '123456',
            'Facebook',
            'User Summary',
            date('Y-m-d H:i:s'),
            '1',
            'Active',
            'tempDeactivate'
        );

        $this->indUserRepository->save($user);
        return $user;
    }
}