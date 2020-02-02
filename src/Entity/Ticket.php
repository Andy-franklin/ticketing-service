<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Helper\QRCodeHelper;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"ticket:output"}},
 *     denormalizationContext={"groups"={"ticket:input"}},
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "delete", "patch",
 *          "check-in" = {
 *              "method": "POST",
 *              "path"= "/tickets/{id}/check-in",
 *              "controller"= CheckInTicket::class,
 *              "openapi_context" = {
 *                  "summary": "Check in the ticket"
 *              }
 *          }
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ApiProperty(identifier=false)
     * @Groups({"ticket:output"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @ApiProperty(identifier=true)
     * @Groups({"ticket:output"})
     */
    private $guid;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"ticket:output", "ticket:input"})
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ticket:output", "ticket:input"})
     */
    private $ticket_type;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"ticket:output"})
     */
    private $qr_image;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"ticket:output"})
     */
    private $checkedInAt;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"ticket:output"})
     */
    private $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"ticket:output"})
     */
    private $updatedAt;

    /**
     * Ticket constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->guid = Uuid::uuid4()->toString();
        QRCodeHelper::generateQRCode('ticket--' . $this->guid);
        $this->qr_image = '/public/qr-codes/ticket--' . $this->guid . '.svg';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getTicketType(): ?string
    {
        return $this->ticket_type;
    }

    public function setTicketType(string $ticket_type): self
    {
        $this->ticket_type = $ticket_type;

        return $this;
    }

    public function getQrImage(): ?string
    {
        return $this->qr_image;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getCheckedInAt(): \DateTime
    {
        return $this->checkedInAt;
    }

    /**
     * @param \DateTime $checkedInAt
     *
     * @return Ticket
     */
    public function setCheckedInAt(\DateTime $checkedInAt): Ticket
    {
        $this->checkedInAt = $checkedInAt;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasCheckedIn(): bool
    {
        return (null !== $this->checkedInAt);
    }
}
