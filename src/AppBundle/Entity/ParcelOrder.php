<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParcelOrder
 *
 * @ORM\Table(name="parcel_order")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParcelOrderRepository")
 */
class ParcelOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Parcel
     *
     * @ORM\ManyToOne(targetEntity="Parcel", cascade={"persist"})
     * @ORM\JoinColumn(name="parcel_id", referencedColumnName="id", nullable=false)
     */
    private $parcel;

    /**
     * @var AddressData
     *
     * @ORM\ManyToOne(targetEntity="AddressData", cascade={"persist"})
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id", nullable=false)
     */
    private $sender;

    /**
     * @var AddressData
     *
     * @ORM\ManyToOne(targetEntity="AddressData", cascade={"persist"})
     * @ORM\JoinColumn(name="receiver_id", referencedColumnName="id", nullable=false)
     */
    private $receiver;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var bool
     *
     * @ORM\Column(name="tracking", type="boolean")
     */
    private $tracking;


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
     * Set parcel
     *
     * @param Parcel $parcel
     *
     * @return ParcelOrder
     */
    public function setParcel($parcel)
    {
        $this->parcel = $parcel;

        return $this;
    }

    /**
     * Get parcel
     *
     * @return Parcel
     */
    public function getParcel()
    {
        return $this->parcel;
    }

    /**
     * Set sender
     *
     * @param AddressData $sender
     *
     * @return ParcelOrder
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return AddressData
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set receiver
     *
     * @param AddressData $receiver
     *
     * @return ParcelOrder
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver
     *
     * @return AddressData
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return ParcelOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set tracking
     *
     * @param boolean $tracking
     *
     * @return ParcelOrder
     */
    public function setTracking($tracking)
    {
        $this->tracking = $tracking;

        return $this;
    }

    /**
     * Get tracking
     *
     * @return bool
     */
    public function getTracking()
    {
        return $this->tracking;
    }
}

