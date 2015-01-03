<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="App\Entity\PageRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * Some methods are from PageTranslation
 * @method Page setTitle
 * @method Page setContent
 * @method Page translate
 */
class Page
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Tag[]
     *
     * @ORM\ManyToMany(targetEntity="Tag")
     */
    private $tags;

    /**
     * TODO: as soon as doctrine 2.5 is out (and this PR merged https://github.com/doctrine/doctrine2/pull/1001)
     *       the postLoad event should be use to fill this field.
     * @var string
     */
    private $preferredLocale;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  ArrayCollection $tags
     * @return self
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getPreferredLocale()
    {
        return $this->preferredLocale;
    }

    /**
     * @param string $preferredLocale
     * @return self
     */
    public function setPreferredLocale($preferredLocale)
    {
        $this->preferredLocale = $preferredLocale;

        return $this;
    }

    /**
     * @return PageTranslation
     */
    public function getPreferredTranslation()
    {
        if ($this->preferredLocale === null && $this->getTranslations()->count() > 0) {
            $this->preferredLocale = $this->getTranslations()->first()->getLocale();
            return $this->getTranslations()->first();
        }

        return $this->translate($this->preferredLocale ?: $this->getCurrentLocale());
    }

    public function __call($method, $arguments)
    {
        if (strpos($method, 'get') !== 0 && strpos($method, 'set') !== 0) {
            $method = 'get' . ucfirst($method);
        }

        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}
