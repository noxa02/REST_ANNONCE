<?php
    include_once '../Application/bootstrap.php';

    $data = Rest::initProcess();
   
    var_dump($data->getData());
    switch($data->getMethod())
    {
            case 'get':

                break;
            case 'post':
                    $user = new User();
                    $user->setFirstName($data->getData()->first_name);  // just for example, this should be done cleaner
                    $user->save();
                    break;
    }

    var_dump($data);