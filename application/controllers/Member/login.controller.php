<?php 
    switch($data->getMethod())
    {
            case 'get':

                break;
            case 'post':
                    $member_ = new Member();
                    $member_->setUserData($data)
                            ->save();
                    break;
    }