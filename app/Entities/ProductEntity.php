<?php

namespace App\Entities;

use DateTime;
use Exception;

class ProductEntity extends Entity
{
    protected string        $name;
    protected string|null   $description;
    protected float         $price;
    protected int           $stock;
    protected int           $category_id;
    protected bool          $is_active;
    protected DateTime|null $created_at;
    protected DateTime|null $updated_at;

    /**
     * Initialize a new product entity.
     *
     * @param array $data The product data.
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
