<?php

namespace App\Entities;

use App\Entities\Exceptions\PropertyNotFoundException;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Collection;
use ReflectionClass;

abstract class Entity
{
    /**
     * Initialize a new entity.
     *
     * @param array $data
     * @throws Exception
     */
    public function __construct(array $data)
    {
        $this->fillAttributes($data);
    }

    /**
     * Dynamically access properties on the entity.
     *
     * @param string $property
     * @return mixed
     * @throws PropertyNotFoundException
     */
    public function __get(string $property): mixed
    {
        if (isset($this->{$property})) {
            return $this->{$property};
        }

        return null;
    }

    /**
     * Dynamically set properties on the entity.
     *
     * @param string $property
     * @param mixed $value
     * @return void
     */
    public function __set(string $property, mixed $value): void
    {
        $this->{$property} = $value;
    }

    /**
     * Fill the entity with attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function fillAttributes(array $attributes): self
    {
        $reflection = new ReflectionClass($this);

        foreach ($attributes as $key => $value) {

            if (is_null($value)) {
                $this->{$key} = $value;
                continue;
            }

            if ($reflection->hasProperty($key)) {
                $property = $reflection->getProperty($key);
                $type = $property->getType();

                if ($type) {
                    $value = $this->castValue($value, $type->getName());
                }

                $property->setAccessible(true);
                $property->setValue($this, $value);
            }
        }

        return $this;
    }

    /**
     * Cast a value to a given type.
     *
     * @param mixed  $value The value to cast.
     * @param string $type The type to cast the value to.
     * @return mixed The casted value.
     */
    protected function castValue(mixed $value, string $type): mixed
    {
        return match ($type) {
            'bool'     => filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false,
            'DateTime' => $this->parseDateTime($value),
            default    => $value,
        };
    }

    /**
     * Get the entity as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    /**
     * Convert the entity to a JSON string.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Convert the entity to a collection.
     *
     * @return Collection
     */
    public function toCollection(): Collection
    {
        return new Collection($this->toArray());
    }

    /**
     * Parse date time.
     *
     * @param DateTime|string|null $value
     * @return DateTime
     * @throws Exception
     */
    public function parseDateTime(DateTime|string|null $value): DateTime
    {
        if ($value instanceof DateTime) {
            return $value;
        }

        try {
            $datetime = $value ? new Carbon($value) : Carbon::now();
            $datetime->setTimezone(new DateTimeZone(config('app.timezone')));

            return $datetime->toDateTime();
        } catch (Exception $exception) {
            throw new Exception("Unable to parse date: {$value}");
        }
    }
}
