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
        $user = $this->indUser->isRegisted('123456', 'Facebook');
        if( !$user )
        {
            $user = $this->indUser->register(
                $post->id,
                $post->genderId,
                $post->countryId,
                $post->Fname,
                $post->Lname,
                $post->Email,
                \Hash::make($post->Password),
                $post->DOB,
                $post->OauthId,
                $post->OauthType,
                $post->Summary,
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s'),
                '1',
                'Active',
                'active'
            );

            $this->indUserRepository->save($user);
        }

        return $user;
    }
}