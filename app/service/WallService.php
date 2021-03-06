<?php

namespace App\Service;

use App\Model\Post;
use App\Model\User;
use Nette\Database\Context;
use Nette\InvalidStateException;
use Nette\Object;

class WallService extends Object
{
    /** @var \Nette\Database\Context */
    private $database;

    /**
     * WallService constructor.
     * @param $database
     */
    public function __construct(Context $database)
    {
        $this->database = $database;
    }
    /**
     * @param ArrayList[Post] $user
     */
    public function getAllPosts(User $user) {
    }

    public function createPost(Post $post) {
        if ($post->getPostId() != null) {
            throw new InvalidStateException("Novy prispevok nesmie mat ID.");
        }

        $row = $this->database->table(Post::TABLE)->insert($post);
        $post->postId = $row->postId;

    }

    public function updatePost(Post $post) {
        if ($post->getPostId() == null){
            throw new InvalidStateException("Obnoveny prispevok musi mat ID.");
        };

        $this->database->table(Post::TABLE)->where('postId', $post->postId)->update($post);
    }

    public function deletePost(Post $post) {
        if ($post->getPostId() == null){
            throw new InvalidStateException("Prispevok, ktory chete zmazat musi mat ID.");
        };

        $this->database->table(Post::TABLE)->where('postId', $post->postId)->delete($post);
    }
}