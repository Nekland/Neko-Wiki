<?php

namespace Nekland\NekoWiki\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Class Role
 *
 * @ORM\Entity(repositoryClass="Nekland\NekoWiki\Entity\User\RoleRepository")
 * @ORM\Table(name="role")
 */
class Role implements RoleHierarchyInterface, RoleInterface, \Serializable
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var Role
     *
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Role", mappedBy="parent")
     */
    private $children;

    /**
     * @var User[]
     *
     * @ORM\ManyToMany(targetEntity="User")
     */
    private $user;

    public function __construct($name = '')
    {
        $this->name     = $name;
        $this->children = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  Nekland\NekoWiki\Entity\User\Role[] $children
     * @return self
     */
    public function setChildren($children)
    {
        $this->children = $children;
        return $this;
    }

    public function addChild(Role $child)
    {
        $this->children->add($child);
        return $this;
    }

    /**
     * @return Nekland\NekoWiki\Entity\User\Role[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param  string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param  Nekland\NekoWiki\Entity\User\Role[] $parent
     * @return self
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        $parent->addChild($this);

        return $this;
    }

    /**
     * @return Nekland\NekoWiki\Entity\User\Role[]
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return Nekland\NekoWiki\Entity\User\User[]
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Returns an array of all reachable roles.
     *
     * Reachable roles are the roles directly assigned but also all roles that
     * are transitively reachable from them in the role hierarchy.
     *
     * @param RoleInterface[] $roles An array of directly assigned roles
     *
     * @return RoleInterface[] An array of all reachable roles
     */
    public function getReachableRoles(array $roles)
    {
        return $this->children->toArray();
    }

    /**
     * Returns the role.
     *
     * This method returns a string representation whenever possible.
     *
     * When the role cannot be represented with sufficient precision by a
     * string, it should return null.
     *
     * @return string|null A string representation of the role, or null
     */
    public function getRole()
    {
        return $this->name;
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->name);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     */
    public function unserialize($serialized)
    {
        $this->name = unserialize($serialized);
    }
}
