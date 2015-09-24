<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Handler;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Form\Handler\ProfileFormHandler as BaseHandler;

class ProfileFormHandler extends BaseHandler {

    public function process(UserInterface $user) {
        $this->form->setData($user);
        if ('POST' === $this->request->getMethod()) {

            $this->form->bind($this->request);



            if ($this->form->isValid()) {

                $user->upload();
                $this->onSuccess($user);
              return true;
            }

            // Reloads the user to reset its username. This is needed when the
            // username or password have been changed to avoid issues with the
            // security layer.
            $this->userManager->reloadUser($user);
        }

        return false;
    }

    protected function onSuccess(UserInterface $user) {
        $this->userManager->updateUser($user);
    }

}
