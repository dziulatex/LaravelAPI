<?php

namespace App\Integrations;

class APIpostsintegration extends JSONIntegration
{
    public $posts;


    public function whatToUpdateAndInsert(array $posts)
    {
        $idsArray = array_column($posts, 'id');
        $existingposts = \DB::table('posts_of_users')->select('id')->whereIn('id', array_column($posts, 'id'))->get();
        $existingposts = $existingposts->pluck('id')->toArray();
        $this->toInsert = array_diff($idsArray, $existingposts);
        $this->toUpdate = array_diff($idsArray, $this->toInsert);
    }


    public function insertOrUpdatePosts(array $posts)
    {
        $this->insertPosts($posts);
        $this->updatePosts($posts);

    }

    public function insertPosts($posts)
    {
        if (!empty($this->toInsert)) {
            foreach ($posts as $key => $post) {
                if (in_array($post['id'], $this->toInsert)) {
                    try {
                        \DB::table('posts_of_users')->insert($post);
                    } catch (\Exception $e) {
                        $this->exceptions[] = [$e->getMessage, 'Błąd w dodawaniu postów', $post];
                    }
                }
            }
        }

    }

    public function updatePosts($posts)
    {
        if (!empty($this->toUpdate)) {
            foreach ($posts as $key => $post) {
                if (in_array($post['id'], $this->toInsert)) {
                    try {
                        \DB::table('posts_of_users')->where('id', $post['id'])->insert($post);
                    } catch (\Exception $e) {
                        $this->exceptions[] = [$e->getMessage, 'Błąd w updatowaniu postów', $post];
                    }

                }
            }
        }
    }
}
