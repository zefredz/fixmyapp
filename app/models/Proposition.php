<?php


/**
 * Paris model to represent a proposition
 */
class Proposition extends Model
{
    /**
     * Helper to get the list of comments
     * @return Comment Paris Model
     */
    public function comments()
    {
        return $this->has_many('Comment');
    }

    /**
     * Helper to get the author of the proposition
     * @return User Paris Model
     */
    public function author()
    {
        return $this->has_one('User');
    }
}
