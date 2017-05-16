<?php

namespace SupermarketBundle\Entity;

/**
 * Receipts
 */
class Receipts
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $validate;

    /**
     * @var int
     */
    private $date;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $delivery;

    /**
     * @var string
     */
    private $billing;

    /**
     * @var string
     */
    private $content;

	/**
	 * @var integer
	 */
	private $total;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set validate
     *
     * @param integer $validate
     *
     * @return Receipts
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;

        return $this;
    }

    /**
     * Get validate
     *
     * @return int
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * Set date
     *
     * @param integer $date
     *
     * @return Receipts
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Receipts
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set delivery
     *
     * @param string $delivery
     *
     * @return Receipts
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * Get delivery
     *
     * @return string
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * Set billing
     *
     * @param string $billing
     *
     * @return Receipts
     */
    public function setBilling($billing)
    {
        $this->billing = $billing;

        return $this;
    }

    /**
     * Get billing
     *
     * @return string
     */
    public function getBilling()
    {
        return $this->billing;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Receipts
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set total
     *
     * @param integer $total
     *
     * @return Receipts
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }
}
