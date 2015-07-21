<?php
/**
 * Created by PhpStorm.
 * User: pem
 * Date: 21/07/15
 * Time: 17:37
 */

namespace Pem\MetaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tag")
 */
class Tag {

    /**
     * @ORM\Id @ORM\Column @ORM\GeneratedValue
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotEmpty
     * @var string
     */
    private $name;

} 