<?php

namespace Harp\MassAssign\Test\Model;

use Harp\Core\Model\AbstractModel;
use Harp\MassAssign\Test\Repo;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Post extends AbstractModel {

    public function getRepo()
    {
        return Repo\Post::get();
    }

    public $id;
    public $name;
    public $body;
    public $userId;

    public function getUser()
    {
        return $this->getLink('user')->get();
    }

    public function setUser(User $user)
    {
        $this->getLink('user')->set($user);

        return $this;
    }
}
