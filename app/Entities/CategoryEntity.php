<?php

namespace App\Entities;

use DateTime;
use Exception;

class CategoryEntity extends Entity
{
    protected int|null      $id;
    protected string        $name;
    protected string|null   $description;
    protected bool          $is_active;
    protected DateTime|null $created_at;
    protected DateTime|null $updated_at;

    /**
     * Initialize a new category entity.
     *
     * @param array $data The category data.
     * @throws Exception
     */
    public function __construct(array $data)
    {
        parent::__construct($data);

        $this->validate();
    }

    /**
     * Validate the entity.
     *
     * @throws Exception
     * @return void
     */
    public function validate(): void
    {
        // @todo - implements new validation method
        if (empty($this->name)) {
            throw new Exception('Name is required');
        }
    }
}
