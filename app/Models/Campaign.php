<?php

namespace App\Models;

/**
 * Class Campaign
 * @package App
 */
class Campaign extends BaseModel
{
    protected $id;
    protected $name;
    protected $description;
    protected $starts_at;
    protected $ends_at;
    protected $suggested_donation;
    protected $target_amount;
    protected $created_by;
    protected $updated_by;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Campaign
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Campaign
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Campaign
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartsAt()
    {
        return $this->starts_at;
    }

    /**
     * @param mixed $starts_at
     * @return Campaign
     */
    public function setStartsAt($starts_at)
    {
        $this->starts_at = $starts_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEndsAt()
    {
        return $this->ends_at;
    }

    /**
     * @param mixed $ends_at
     * @return Campaign
     */
    public function setEndsAt($ends_at)
    {
        $this->ends_at = $ends_at;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSuggestedDonation()
    {
        return $this->suggested_donation;
    }

    /**
     * @param mixed $suggested_donation
     * @return Campaign
     */
    public function setSuggestedDonation($suggested_donation)
    {
        $this->suggested_donation = $suggested_donation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTargetAmount()
    {
        return $this->target_amount;
    }

    /**
     * @param mixed $target_amount
     * @return Campaign
     */
    public function setTargetAmount($target_amount)
    {
        $this->target_amount = $target_amount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param mixed $created_by
     * @return Campaign
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedBy()
    {
        return $this->updated_by;
    }

    /**
     * @param mixed $updated_by
     * @return Campaign
     */
    public function setUpdatedBy($updated_by)
    {
        $this->updated_by = $updated_by;
        return $this;
    }

}
