<?php namespace FixMyApp\Models;

/**
 * Paris model to represent a comment
 */
class Comment extends \Model
{
    public static $_table = 'comment';
    /**
     * Helper to get the related proposition
     * @retrun Proposition Paris Model
     */
    public function proposition()
    {
        return $this->belongs_to('Proposition');
    }

    /**
     * Helper to get the related author
     * @return User Paris Model
     */
    public function author()
    {
        return $this->has_one('User');
    }
}
