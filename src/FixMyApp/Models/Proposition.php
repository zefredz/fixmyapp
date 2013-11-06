<?php namespace FixMyApp\Models;

use Paris\Dbal\Model;

/**
 * Paris model to represent a proposition
 */
class Proposition extends Model
{
    public static $_table = 'proposition';

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
