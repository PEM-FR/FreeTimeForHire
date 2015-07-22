<?php
/**
 * Created by PhpStorm.
 * User: pem
 * Date: 21/07/15
 * Time: 16:00
 */

namespace Pem\ProjectBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
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

    /**
     * @Gedmo\Slug(fields={"label"})
     * @ORM\Column(length=128, unique=true)
     * @Assert\NotEmpty
     * @var String
     */
    private $slug;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="date")
     * @Assert\NotEmpty
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     *
     */
    public function __construct() {
        $this->tags     = new ArrayCollection();
        $this->users    = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $repositoryUrl
     */
    public function setRepositoryUrl($repositoryUrl)
    {
        $this->repositoryUrl = $repositoryUrl;
    }

    /**
     * @return string
     */
    public function getRepositoryUrl()
    {
        return $this->repositoryUrl;
    }

    /**
     * @param string $demoUrl
     */
    public function setDemoUrl($demoUrl)
    {
        $this->demoUrl = $demoUrl;
    }

    /**
     * @return string
     */
    public function getDemoUrl()
    {
        return $this->demoUrl;
    }

    /**
     * @return ArrayCollection of Meta\Tag
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return String
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param Meta\Tag $tag
     * @throws \Exception
     */
    public function addTag(Meta\Tag $tag)
    {
        $tags = $this->_getTags();
        if ($this->hasTag($tag)) {
            throw new \Exception(__('project.had.tag', array('label' => $tag->getLabel())));
        }
        $tags->add($tag);
    }

    /**
     * @param Meta\Tag $tag
     * @throws \Exception
     */
    public function removeTag(Meta\Tag $tag)
    {
        $tags = $this->_getTags();
        $tagLabel = $tag->getLabel();
        if (!$this->hasTag($tag)) {
            throw new \Exception(__('project.has.not.tag', array('label' => $tagLabel)));
        }
        $tags->remove($tagLabel);
    }

    public function hasTag(Meta\Tag $tag)
    {
        $tags = $this->_getTags();
        return $tags->containsKey($tag->getLabel());
    }
}