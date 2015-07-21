<?php
/**
 * Created by PhpStorm.
 * User: pem
 * Date: 21/07/15
 * Time: 16:00
 */

namespace Pem\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
use Pem\MetaBundle\Entity as Meta;

/**
 * @ORM\Entity
 * @ORM\Table(name="project")
 */
class Project {

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
    private $label;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url
     * @var string
     */
    private $repositoryUrl;

    /**
     * @ORM\Column(type="string")
     * @Assert\Url
     * @var string
     */
    private $demoUrl;

    /**
     * @ManyToMany(targetEntity="\Meta\Tag")
     * @JoinTable(name="projects_tags",
     *      joinColumns={@JoinColumn(name="project_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     * @Assert\NotEmpty
     * @var ArrayCollection of Meta\Tag
     **/
    private $tags;

    public function __construct() {
        $this->tags     = new ArrayCollection();
        $this->users    = new ArrayCollection();
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function addTag(Meta\Tag $tag)
    {
        $tags = $this->_getTags();
        if ($tags->containsKey($tag->getLabel())) {
            throw new \Exception(__('project.had.tag'));
        }
        $tags->add($tag);
    }

    public function removeTag(Meta\Tag $tag)
    {
        $tags = $this->_getTags();
        $tagLabel = $tag->getLabel();
        if (!$tags->containsKey($tagLabel)) {
            throw new \Exception(__('project.has.not.tag'));
        }
        $tags->remove($tagLabel);
    }
}